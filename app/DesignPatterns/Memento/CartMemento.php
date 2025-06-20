<?php

namespace App\DesignPatterns\Memento;

/**
 * Lớp Memento này chỉ đơn giản là một "cái hộp" để lưu trạng thái của giỏ hàng.
 * Nó không có logic gì phức tạp.
 */
class CartMemento
{
    /**
     * @var array Trạng thái được lưu của giỏ hàng (danh sách sản phẩm, tổng tiền...)
     */
    private array $state;

    public function __construct(array $state)
    {
        $this->state = $state;
    }

    /**
     * Lấy lại trạng thái đã được lưu.
     */
    public function getState(): array
    {
        return $this->state;
    }
}