<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use App\Services\Cart;
use App\Services\CartHistory; // <-- Thêm CartHistory

class CartController extends Controller
{
    public function index(Cart $cart)
    {
        // ... giữ nguyên ...
    }

    public function add(Fruit $fruit, Cart $cart, CartHistory $history) // <-- Inject CartHistory
    {
        // BƯỚC QUAN TRỌNG:
        // 1. Sao lưu trạng thái HIỆN TẠI của giỏ hàng VÀO LỊCH SỬ.
        $history->backup($cart);
        
        // 2. Sau đó mới thực hiện hành động THAY ĐỔI trạng thái.
        $cart->add($fruit);
        
        return back()->with('message', "Đã thêm {$fruit->name} vào giỏ!");
    }
    
    public function undo(Cart $cart, CartHistory $history) // <-- Inject CartHistory
    {
        // Chỉ cần gọi phương thức undo, nó sẽ tự xử lý mọi việc.
        $history->undo($cart);
        
        return back()->with('message', 'Đã hoàn tác hành động cuối cùng!');
    }
}