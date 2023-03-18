<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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

    return redirect()->route('products.lists');
});
  
Route::get('/product', [ProductController::class, 'index'])->name('products.lists');
Route::get('/product/lists/show',  [ProductController::class, 'getAllProducts']);
Route::post('/product/create', [ProductController::class, 'create'])->name('product.store');
Route::post('/product/update', [ProductController::class, 'update'])->name('product.update');
Route::post('/product/delete', [ProductController::class, 'delete'])->name('product.delete');