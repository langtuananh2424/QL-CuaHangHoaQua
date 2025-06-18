<?php

namespace App\Services;

use App\Services\Cart; // <-- Quan trọng: Nó làm việc với Cart

class CartHistory
{
    /**
     * @var array Một mảng hoạt động như một "chồng" (stack) để lưu các Memento.
     */
    private array $mementos = [];

    public function __construct()
    {
        // Lấy lịch sử từ session ra khi khởi tạo
        $this->mementos = session('cart_history', []);
    }

    /**
     * Yêu cầu Cart tạo một bản sao lưu (Memento) và cất nó vào lịch sử.
     * Phương thức này sẽ được gọi TRƯỚC KHI thực hiện một hành động (ví dụ: thêm sản phẩm).
     */
    public function backup(Cart $cart): void
    {
        // Bảo Cart "tự lưu mình lại" và đưa Memento cho mình giữ
        $this->mementos[] = $cart->saveStateToMemento();
        $this->saveToSession();
    }

    /**
     * Lấy Memento gần nhất ra khỏi lịch sử và yêu cầu Cart khôi phục lại trạng thái đó.
     */
    public function undo(Cart $cart): void
    {
        if (empty($this->mementos)) {
            // Không có gì trong lịch sử để hoàn tác
            return;
        }

        // Lấy bản ghi nhớ cuối cùng ra khỏi "chồng"
        $memento = array_pop($this->mementos);

        // Đưa bản ghi nhớ này cho Cart và bảo nó "hãy quay về trạng thái này"
        $cart->restoreStateFromMemento($memento);
        $this->saveToSession();
    }

    private function saveToSession(): void
    {
        session(['cart_history' => $this->mementos]);
    }
}