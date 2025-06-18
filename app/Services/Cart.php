<?php

namespace App\Services;

use App\Mementos\CartMemento; // <-- Thêm dòng này
use App\Models\Fruit;

class Cart
{
    private array $items = [];
    private float $total = 0.0;

    public function __construct()
    {
        $this->items = session('cart.items', []);
        $this->total = session('cart.total', 0.0);
    }
    
    // ... các phương thức khác như add(), remove(), getContents()... giữ nguyên ...

    // =======================================================
    // ===== CÁC PHƯƠNG THỨC ĐẶC BIỆT CHO MEMENTO PATTERN =====
    // =======================================================

    /**
     * Tạo một "bản ghi nhớ" (Memento) chứa trạng thái hiện tại của giỏ hàng.
     * @return CartMemento
     */
    public function saveStateToMemento(): CartMemento
    {
        // Lấy trạng thái hiện tại (items và total) và gói nó vào một đối tượng Memento.
        $currentState = ['items' => $this->items, 'total' => $this->total];
        return new CartMemento($currentState);
    }

    public function add(Fruit $fruit, int $quantity = 1)
    {
    $id = $fruit->id;

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    if (isset($this->items[$id])) {
        // Nếu đã có, chỉ cần cập nhật số lượng
        $this->items[$id]['quantity'] += $quantity;
    } else {
        // Nếu chưa có, tạo một mục mới
        $this->items[$id] = [
            'name' => $fruit->name,
            'quantity' => $quantity,
            'price' => $fruit->price,
        ];
    }

    // Tính toán lại tổng tiền và lưu vào session
        $this->calculateTotal();
        $this->saveToSession();
    }
    public function restoreStateFromMemento(CartMemento $memento)
    {
        // Lấy trạng thái từ Memento và cập nhật lại cho chính đối tượng Cart này.
        $state = $memento->getState();
        $this->items = $state['items'];
        $this->total = $state['total'];

        // Đừng quên lưu lại vào session sau khi khôi phục
        $this->saveToSession();
    }

    private function saveToSession()
    {
        session(['cart.items' => $this->items, 'cart.total' => $this->total]);
    }
    
    // ... các phương thức helper khác ...
}