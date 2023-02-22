<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::controller(PageController::class)->group(function () {
    Route::get('category', 'category')->name('page.category')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('catalogue', 'catalogue')->name('page.catalogue')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);    
    Route::get('product', 'product')->name('page.product')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('show/{category}', 'show')->name('page.show')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
    Route::get('cart', 'cart')->name('page.cart')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
});
