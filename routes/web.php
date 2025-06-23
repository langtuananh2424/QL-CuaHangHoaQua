<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FruitDataController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.products');
    }
    abort(403);
})->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'show'])->name('cart.show');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/cancel', [CartController::class, 'cancel'])->name('cart.cancel');
    Route::post('/cart/remove-item/{itemId}', [CartController::class, 'removeItem'])->name('cart.removeItem');
    Route::post('/cart/undo', [CartController::class, 'undoCart'])->name('cart.undo');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/admin/orders/{id}/edit', [AdminController::class, 'editOrder'])->name('admin.orders.edit');
    Route::post('/admin/orders/{id}/update', [AdminController::class, 'updateOrder'])->name('admin.orders.update');
    Route::delete('/admin/orders/{id}', [AdminController::class, 'deleteOrder'])->name('admin.orders.delete');
    Route::get('/admin/products/create', [AdminController::class, 'createProduct'])->name('admin.products.create');
    Route::post('/admin/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.products.edit');
    Route::post('/admin/products/{id}/update', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::delete('/admin/products/{id}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');
    Route::get('/admin/customers/{id}/edit', [AdminController::class, 'editCustomer'])->name('admin.customers.edit');
    Route::post('/admin/customers/{id}/update', [AdminController::class, 'updateCustomer'])->name('admin.customers.update');
    Route::delete('/admin/customers/{id}', [AdminController::class, 'deleteCustomer'])->name('admin.customers.delete');

    // Routes cho Factory Pattern - Chỉ admin mới có thể truy cập
    Route::middleware('admin')->group(function () {
        Route::get('/admin/fruit-data', [FruitDataController::class, 'index'])->name('admin.fruit-data');
        Route::post('/admin/fruit-data/create', [FruitDataController::class, 'createData'])->name('admin.fruit-data.create');
        Route::post('/admin/fruit-data/single', [FruitDataController::class, 'createSingleFruit'])->name('admin.fruit-data.single');
        Route::post('/admin/fruit-data/demo', [FruitDataController::class, 'createDemoData'])->name('admin.fruit-data.demo');
        Route::post('/admin/fruit-data/clear', [FruitDataController::class, 'clearData'])->name('admin.fruit-data.clear');
        Route::get('/admin/fruit-data/statistics', [FruitDataController::class, 'getStatistics'])->name('admin.fruit-data.statistics');
    });
});

Route::get('/fruits/{id}', [\App\Http\Controllers\HomeController::class, 'showFruit'])->name('fruits.show');

require __DIR__.'/auth.php';
