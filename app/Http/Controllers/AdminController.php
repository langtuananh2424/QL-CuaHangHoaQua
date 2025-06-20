<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function products()
    {
        $products = Fruit::all();
        return view('admin.products', compact('products'));
    }

    public function customers()
    {
        $customers = User::where('role', 'customer')->get();
        return view('admin.customers', compact('customers'));
    }

    public function orders()
    {
        $orders = Order::with(['user', 'orderItems.fruit'])->orderByDesc('created_at')->get();
        return view('admin.orders', compact('orders'));
    }

    public function editOrder($id)
    {
        $order = Order::with(['user', 'orderItems.fruit'])->findOrFail($id);
        return view('admin.edit_order', compact('order'));
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);
        $order->status = $request->status;
        $order->save();
        return redirect()->route('admin.orders')->with('success', 'Cập nhật đơn hàng thành công!');
    }

    public function deleteOrder($id)
    {
        $order = Order::findOrFail($id);
        $order->orderItems()->delete();
        $order->delete();
        return redirect()->route('admin.orders')->with('success', 'Đã xóa đơn hàng!');
    }

    public function createProduct()
    {
        return view('admin.create_product');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'is_discount' => 'nullable|boolean',
            'is_clean' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $data = $request->only(['name','price','old_price','description','stock','is_discount','is_clean']);
        $data['is_discount'] = $request->has('is_discount') ? 1 : 0;
        $data['is_clean'] = $request->has('is_clean') ? 1 : 0;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('fruits', 'public');
        }
        \App\Models\Fruit::create($data);
        return redirect()->route('admin.products')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function editProduct($id)
    {
        $product = \App\Models\Fruit::findOrFail($id);
        return view('admin.edit_product', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = \App\Models\Fruit::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'is_discount' => 'nullable|boolean',
            'is_clean' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $data = $request->only(['name','price','old_price','description','stock','is_discount','is_clean']);
        $data['is_discount'] = $request->has('is_discount') ? 1 : 0;
        $data['is_clean'] = $request->has('is_clean') ? 1 : 0;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('fruits', 'public');
        }
        $product->update($data);
        return redirect()->route('admin.products')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function deleteProduct($id)
    {
        $product = \App\Models\Fruit::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Đã xóa sản phẩm!');
    }

    public function editCustomer($id)
    {
        $customer = \App\Models\User::where('role', 'customer')->findOrFail($id);
        return view('admin.edit_customer', compact('customer'));
    }

    public function updateCustomer(Request $request, $id)
    {
        $customer = \App\Models\User::where('role', 'customer')->orWhere('role', 'admin')->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'role' => 'required|in:customer,admin',
            'password' => 'nullable|string|min:6',
        ]);
        $data = $request->only(['name', 'email', 'phone', 'address', 'role']);
        if ($request->filled('password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $customer->update($data);
        return redirect()->route('admin.customers')->with('success', 'Cập nhật khách hàng thành công!');
    }

    public function deleteCustomer($id)
    {
        $customer = \App\Models\User::where('role', 'customer')->findOrFail($id);
        $customer->delete();
        return redirect()->route('admin.customers')->with('success', 'Đã xóa khách hàng!');
    }
}
