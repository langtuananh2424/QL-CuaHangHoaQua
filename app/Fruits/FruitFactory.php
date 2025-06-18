<?php

namespace App\Fruits;

use App\Fruits\Contracts\FruitInterface;
use App\Fruits\Types\{
    Apple,
    Orange,
    Mango,
    Banana,
    Watermelon,
    Pineapple,
    Pear,
    Grape,
    Strawberry,
    Papaya,
    Kiwi,
    Plum,
    Jackfruit,
    Durian,
    Lychee,
    Longan,
    GenericFruit
};

class FruitFactory
{
    public static function create(string $type): FruitInterface
    {
        return match (strtolower($type)) {
            'apple'       => new Apple(),
            'orange'      => new Orange(),
            'mango'       => new Mango(),
            'banana'      => new Banana(),
            'watermelon'  => new Watermelon(),
            'pineapple'   => new Pineapple(),
            'pear'        => new Pear(),
            'grape'       => new Grape(),
            'strawberry'  => new Strawberry(),
            'papaya'      => new Papaya(),
            'kiwi'        => new Kiwi(),
            'plum'        => new Plum(),
            'jackfruit'   => new Jackfruit(),
            'durian'      => new Durian(),
            'lychee'      => new Lychee(),
            'longan'      => new Longan(),
            default       => new GenericFruit(),
        };
    }
}
