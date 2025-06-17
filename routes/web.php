<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FruitController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/fruits', [FruitController::class, 'index'])->name('fruits.index');

