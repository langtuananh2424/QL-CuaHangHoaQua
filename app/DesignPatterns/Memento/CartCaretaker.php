<?php

namespace App\DesignPatterns\Memento;

class CartCaretaker
{
    const SESSION_KEY = 'cart_memento';

    public static function save(CartMemento $memento): void
    {
        session([self::SESSION_KEY => $memento]);
    }

    public static function restore(): ?CartMemento
    {
        $memento = session(self::SESSION_KEY, null);
        return $memento instanceof CartMemento ? $memento : null;
    }
}
