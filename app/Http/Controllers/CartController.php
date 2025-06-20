<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fruit;
use App\DesignPatterns\Memento\Cart;
use App\DesignPatterns\Memento\CartCaretaker;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

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

        // Cập nhật tồn kho cho các sản phẩm được thanh toán
        foreach ($selectedItems as $item) {
            $fruit = $item->fruit;
            if ($fruit) {
                $fruit->stock = max(0, $fruit->stock - $item->quantity);
                $fruit->save();
            }
        }

        // Nếu chọn hết thì chuyển trạng thái order sang completed
        if ($selectedItems->count() === $order->orderItems->count()) {
            $order->status = 'completed';
            $order->save();
        } else {
            // Tạo order mới completed với các item được chọn
            $newOrder = \App\Models\Order::create([
                'user_id' => $user->id,
                'total_amount' => 0,
                'final_amount' => 0,
                'status' => 'completed',
            ]);
            $total = 0;
            foreach ($selectedItems as $item) {
                $newOrder->orderItems()->create([
                    'fruit_id' => $item->fruit_id,
                    'quantity' => $item->quantity,
                ]);
                $total += $item->quantity * $item->fruit->price;
                $item->delete();
            }
            $newOrder->total_amount = $total;
            $newOrder->final_amount = $total;
            $newOrder->save();
            // Cập nhật lại tổng tiền order pending
            $pendingTotal = 0;
            foreach ($order->orderItems as $item) {
                $pendingTotal += $item->quantity * $item->fruit->price;
            }
            $order->total_amount = $pendingTotal;
            $order->final_amount = $pendingTotal;
            $order->save();
        }
        return redirect()->route('home')->with('success', 'Thanh toán thành công!');
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
}
