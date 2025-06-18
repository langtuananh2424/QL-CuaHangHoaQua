<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FruitController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/fruits', [FruitController::class, 'index'])->name('fruits.index');
Route::get('/fruits/group', [FruitController::class, 'group'])->name('fruits.group');
Route::get('/fruits/more', [FruitController::class, 'more'])->name('fruits.more');


Route::get('/fruits/category/{type}', [FruitController::class, 'category'])->name('fruits.category');

