<?php

namespace App\Http\Controllers;

use App\Models\Fruit;
use Illuminate\Http\Request;

class FruitController extends Controller
{
    public function index()
    {
        $saleFruits = Fruit::where('is_on_sale', true)->take(4)->get();
        $premiumFruits = Fruit::where('is_premium', true)->take(4)->get();
        $organicFruits = Fruit::where('is_organic', true)->take(4)->get();

        return view('fruits.index', compact('saleFruits', 'premiumFruits', 'organicFruits'));
    }

    public function category(string $type)
    {
        $query = Fruit::query();

        if ($type === 'sale') {
            $query->where('is_on_sale', true);
        } elseif ($type === 'premium') {
            $query->where('is_premium', true);
        } elseif ($type === 'organic') {
            $query->where('is_organic', true);
        }

        $fruits = $query->paginate(12);

        return view('fruits.category', compact('fruits', 'type'));
    }
}
