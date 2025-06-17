<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\InventoryManagerInterface;
use App\Decorators\SaleBadgeDecorator;
use App\Decorators\PremiumPackagingDecorator;
use App\Decorators\OrganicFruitDecorator;

class FruitController extends Controller
{
    protected InventoryManagerInterface $inventory;

    public function __construct(InventoryManagerInterface $inventory)
    {
        $this->inventory = $inventory;
    }

    public function index(Request $request)
    {
        $fruits = $this->inventory->getAllFruits();

        // Lọc theo type
        if ($request->filled('type')) {
            $fruits = $fruits->where('type', $request->input('type'));
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price')) {
            $fruits = $fruits->where('price', '>=', (float)$request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $fruits = $fruits->where('price', '<=', (float)$request->input('max_price'));
        }

        $useSale = $request->has('sale');
        $usePremium = $request->has('premium');
        $useOrganic = $request->has('organic');

        $displayFruits = $fruits->map(function ($fruit) use ($useSale, $usePremium, $useOrganic) {
            $decorated = $fruit;

            if ($useSale) {
                $decorated = new SaleBadgeDecorator($decorated);
            }

            if ($usePremium) {
                $decorated = new PremiumPackagingDecorator($decorated);
            }

            if ($useOrganic) {
                $decorated = new OrganicFruitDecorator($decorated);
            }

            return $decorated->display();
        });

        return view('fruits.index', [
            'fruits' => $displayFruits,
            'filters' => $request->only(['type', 'min_price', 'max_price', 'sale', 'premium', 'organic'])
        ]);
    }

}
