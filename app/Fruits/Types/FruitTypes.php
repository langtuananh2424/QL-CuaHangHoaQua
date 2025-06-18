<?php

namespace App\Fruits\Types;

use App\Fruits\Contracts\FruitInterface;

class Apple implements FruitInterface {
    public function getName(): string {
        return 'Táo';
    }
    public function getPrice(): float {
        return 20000;
    }
    public function getDescription(): string {
        return 'Một quả táo tươi ngon.';
    }
}

class Orange implements FruitInterface {
    public function getName(): string {
        return 'Cam';
    }
    public function getPrice(): float {
        return 25000;
    }
    public function getDescription(): string {
        return 'Một quả cam mọng nước.';
    }
}

class Mango implements FruitInterface {
    public function getName(): string {
        return 'Xoài';
    }
    public function getPrice(): float {
        return 30000;
    }
    public function getDescription(): string {
        return 'Một quả xoài chín vàng.';
    }
}

class Banana implements FruitInterface {
    public function getName(): string {
        return 'Chuối';
    }
    public function getPrice(): float {
        return 15000;
    }
    public function getDescription(): string {
        return 'Một nải chuối thơm lừng.';
    }
}

class Watermelon implements FruitInterface {
    public function getName(): string {
        return 'Dưa hấu';
    }
    public function getPrice(): float {
        return 50000;
    }
    public function getDescription(): string {
        return 'Một quả dưa hấu mát lạnh.';
    }
}

class Pineapple implements FruitInterface {
    public function getName(): string {
        return 'Dứa';
    }
    public function getPrice(): float {
        return 18000;
    }
    public function getDescription(): string {
        return 'Một quả dứa chín thơm.';
    }
}

class Pear implements FruitInterface {
    public function getName(): string {
        return 'Lê';
    }
    public function getPrice(): float {
        return 22000;
    }
    public function getDescription(): string {
        return 'Một quả lê ngọt mát.';
    }
}

class Grape implements FruitInterface {
    public function getName(): string {
        return 'Nho';
    }
    public function getPrice(): float {
        return 28000;
    }
    public function getDescription(): string {
        return 'Một chùm nho căng mọng.';
    }
}

class Strawberry implements FruitInterface {
    public function getName(): string {
        return 'Dâu tây';
    }
    public function getPrice(): float {
        return 40000;
    }
    public function getDescription(): string {
        return 'Một hộp dâu tây đỏ mọng.';
    }
}

class Papaya implements FruitInterface {
    public function getName(): string {
        return 'Đu đủ';
    }
    public function getPrice(): float {
        return 26000;
    }
    public function getDescription(): string {
        return 'Một quả đu đủ vàng ươm.';
    }
}

class Kiwi implements FruitInterface {
    public function getName(): string {
        return 'Kiwi';
    }
    public function getPrice(): float {
        return 32000;
    }
    public function getDescription(): string {
        return 'Một quả kiwi tươi mới.';
    }
}

class Plum implements FruitInterface {
    public function getName(): string {
        return 'Mận';
    }
    public function getPrice(): float {
        return 23000;
    }
    public function getDescription(): string {
        return 'Một quả mận ngọt lịm.';
    }
}

class Jackfruit implements FruitInterface {
    public function getName(): string {
        return 'Mít';
    }
    public function getPrice(): float {
        return 35000;
    }
    public function getDescription(): string {
        return 'Một múi mít thơm lừng.';
    }
}

class Durian implements FruitInterface {
    public function getName(): string {
        return 'Sầu riêng';
    }
    public function getPrice(): float {
        return 120000;
    }
    public function getDescription(): string {
        return 'Một múi sầu riêng béo ngậy.';
    }
}

class Lychee implements FruitInterface {
    public function getName(): string {
        return 'Vải';
    }
    public function getPrice(): float {
        return 27000;
    }
    public function getDescription(): string {
        return 'Một chùm vải chín mọng.';
    }
}

class Longan implements FruitInterface {
    public function getName(): string {
        return 'Nhãn';
    }
    public function getPrice(): float {
        return 25000;
    }
    public function getDescription(): string {
        return 'Một chùm nhãn ngọt thơm.';
    }
}

class GenericFruit implements FruitInterface {
    public function getName(): string {
        return 'Trái cây không xác định';
    }
    public function getPrice(): float {
        return 10000;
    }
    public function getDescription(): string {
        return 'Một loại trái cây chưa rõ.';
    }
}
