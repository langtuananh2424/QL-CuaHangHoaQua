<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fruit;
use App\DesignPatterns\Memento\Cart;
use App\DesignPatterns\Memento\CartCaretaker;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\DesignPatterns\Observer\OrderPlaced;
use App\DesignPatterns\Facade\CheckoutFacade;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $user = Auth::user();
        $product = Fruit::findOrFail($id);

        // Tìm order pending của user, nếu chưa có thì tạo mới
        $order = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        if (!$order) {
            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'total_amount' => 0,
                'final_amount' => 0,
                'status' => 'pending',
            ]);
        }

        // Thêm hoặc cập nhật order_item
        $orderItem = $order->orderItems()->where('fruit_id', $product->id)->first();
        if ($orderItem) {
            $orderItem->quantity++;
            $orderItem->save();
        } else {
            $order->orderItems()->create([
                'fruit_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        // Cập nhật lại tổng tiền
        $total = 0;
        foreach ($order->orderItems as $item) {
            $total += $item->quantity * $item->fruit->price;
        }
        $order->total_amount = $total;
        $order->final_amount = $total;
        $order->save();

        return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function show()
    {
        $user = Auth::user();
        $order = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();

        $items = $order ? $order->orderItems : collect();
        return view('cart.show', compact('items'));
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $order = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        if (!$order || $order->orderItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Giỏ hàng trống!');
        }

        $selected = $request->input('selected_items');
        $selectedItems = $selected ? $order->orderItems()->whereIn('id', $selected)->get() : $order->orderItems;
        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Bạn chưa chọn sản phẩm nào để thanh toán!');
        }

        // Chuẩn bị dữ liệu cho Facade
        $orderData = [
            'customer_name' => $user->name,
            'user_id' => $user->id,
        ];
        $items = [];
        foreach ($selectedItems as $item) {
            $items[] = [
                'fruit_id' => $item->fruit_id,
                'quantity' => $item->quantity,
            ];
        }
        $discountRate = 0; // Có thể lấy từ request nếu có khuyến mãi

        \Log::info('THANH TOÁN: Gọi Facade', [
            'pending_order_id' => $order->id,
            'orderData' => $orderData,
            'items' => $items
        ]);
        $facade = new CheckoutFacade();
        $result = $facade->processOrder($order->id, $orderData, $items, $discountRate);
        \Log::info('THANH TOÁN: Kết quả Facade trả về', $result);

        // --- LƯU LẠI SẢN PHẨM VỪA THANH TOÁN ĐỂ HOÀN TÁC ---
        $justPaidItems = $selectedItems->map(function($item) {
            return [
                'fruit_id' => $item->fruit_id,
                'quantity' => $item->quantity,
            ];
        })->toArray();
        session(['just_paid_items' => $justPaidItems]);
        // -----------------------------------------------------

        if ($result['success']) {
            return redirect()->route('home')->with('success', 'Thanh toán thành công!');
        } else {
            return redirect()->route('cart.show')->with('error', $result['message']);
        }
    }

    public function cancel()
    {
        $user = Auth::user();
        $order = \App\Models\Order::where('user_id', $user->id)->where('status', 'pending')->first();
        if ($order) {
            $order->status = 'cancelled';
            $order->save();
            // (Không xóa order_items để lưu lịch sử)
            return redirect()->route('cart.show')->with('success', 'Đã hủy giỏ hàng!');
        }
        return redirect()->route('cart.show')->with('error', 'Không tìm thấy giỏ hàng để hủy!');
    }

    public function removeItem($itemId)
    {
        $user = Auth::user();
        $order = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        if ($order) {
            $item = $order->orderItems()->where('id', $itemId)->first();
            if ($item) {
                // Lưu lại sản phẩm vừa xóa để hoàn tác
                \Log::info('Lưu just_removed_item', [
                    'fruit_id' => $item->fruit_id,
                    'quantity' => $item->quantity,
                ]);
                session(['just_removed_item' => [
                    'fruit_id' => $item->fruit_id,
                    'quantity' => $item->quantity,
                ]]);
                $item->delete();
                // Cập nhật lại tổng tiền
                $total = 0;
                foreach ($order->orderItems as $orderItem) {
                    $total += $orderItem->quantity * $orderItem->fruit->price;
                }
                $order->total_amount = $total;
                $order->final_amount = $total;
                $order->save();
                return redirect()->route('cart.show')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
            }
        }
        return redirect()->route('cart.show')->with('error', 'Không tìm thấy sản phẩm để xóa!');
    }

    public function undoCart()
    {
        $user = Auth::user();
        $order = \App\Models\Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->first();
        // Ưu tiên hoàn tác sản phẩm vừa xóa
        $justRemovedItem = session('just_removed_item', null);
        \Log::info('Lấy just_removed_item trong undoCart', ['just_removed_item' => $justRemovedItem]);
        if ($justRemovedItem) {
            if (!$order) {
                $order = \App\Models\Order::create([
                    'user_id' => $user->id,
                    'total_amount' => 0,
                    'final_amount' => 0,
                    'status' => 'pending',
                ]);
            }
            $orderItem = $order->orderItems()->where('fruit_id', $justRemovedItem['fruit_id'])->first();
            if ($orderItem) {
                $orderItem->quantity += $justRemovedItem['quantity'];
                $orderItem->save();
            } else {
                $order->orderItems()->create([
                    'fruit_id' => $justRemovedItem['fruit_id'],
                    'quantity' => $justRemovedItem['quantity'],
                ]);
            }
            // Cập nhật lại tổng tiền
            $pendingTotal = 0;
            foreach ($order->orderItems as $item) {
                $pendingTotal += $item->quantity * $item->fruit->price;
            }
            $order->total_amount = $pendingTotal;
            $order->final_amount = $pendingTotal;
            $order->save();
            session()->forget('just_removed_item');
            \Log::info('Đã hoàn tác sản phẩm vừa xóa', ['fruit_id' => $justRemovedItem['fruit_id'], 'quantity' => $justRemovedItem['quantity']]);
            return redirect()->route('cart.show')->with('success', 'Đã hoàn tác sản phẩm vừa xóa!');
        }
        // Nếu không có sản phẩm vừa xóa, hoàn tác sản phẩm vừa thanh toán như hiện tại
        $justPaidItems = session('just_paid_items', []);
        if (empty($justPaidItems)) {
            return redirect()->route('cart.show')->with('error', 'Không có sản phẩm nào để hoàn tác!');
        }
        if (!$order) {
            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'total_amount' => 0,
                'final_amount' => 0,
                'status' => 'pending',
            ]);
        }
        foreach ($justPaidItems as $item) {
            $orderItem = $order->orderItems()->where('fruit_id', $item['fruit_id'])->first();
            if ($orderItem) {
                $orderItem->quantity += $item['quantity'];
                $orderItem->save();
            } else {
                $order->orderItems()->create([
                    'fruit_id' => $item['fruit_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }
        $pendingTotal = 0;
        foreach ($order->orderItems as $item) {
            $pendingTotal += $item->quantity * $item->fruit->price;
        }
        $order->total_amount = $pendingTotal;
        $order->final_amount = $pendingTotal;
        $order->save();
        session()->forget('just_paid_items');
        \Log::info('Đã hoàn tác sản phẩm vừa thanh toán', ['just_paid_items' => $justPaidItems]);
        return redirect()->route('cart.show')->with('success', 'Đã hoàn tác sản phẩm vừa thanh toán!');
    }
}
