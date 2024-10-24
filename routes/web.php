<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductCrudController;
use App\Http\Controllers\Admin\CategoryCrudController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/categories', [CategoryCrudController::class, 'index'])->name('categories.index');
Route::crud('product', ProductCrudController::class);
Route::get('/products/create', [ProductCrudController::class, 'create'])->name('products.create');
Route::post('/products', [ProductCrudController::class, 'store'])->name('products.store');
