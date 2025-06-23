<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fruit;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        if ($query) {
            $newProducts = Fruit::where('name', 'like', "%$query%")
                ->where('stock', '>', 0)
                ->orderBy('created_at', 'desc')->take(8)->get();
            $discountProducts = Fruit::where('is_discount', true)
                ->where('name', 'like', "%$query%")
                ->where('stock', '>', 0)
                ->take(8)->get();
            $cleanFruits = Fruit::where('is_clean', true)
                ->where('name', 'like', "%$query%")
                ->where('stock', '>', 0)
                ->take(8)->get();
        } else {
            $newProducts = Fruit::where('stock', '>', 0)->orderBy('created_at', 'desc')->take(8)->get();
            $discountProducts = Fruit::where('is_discount', true)->where('stock', '>', 0)->take(8)->get();
            $cleanFruits = Fruit::where('is_clean', true)->where('stock', '>', 0)->take(8)->get();
        }

        return view('home', [
            'newProducts' => $newProducts,
            'discountProducts' => $discountProducts,
            'cleanFruits' => $cleanFruits,
            'searchQuery' => $query,
        ]);
    }

    public function showFruit($id)
    {
        $fruit = \App\Models\Fruit::findOrFail($id);
        return view('fruits.show', compact('fruit'));
    }
}
