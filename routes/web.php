<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\WithdrawController;
use App\Models\TransactionReport;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/faq', function () {
    return view('faq');
})->name('faq');
Route::get('/contact', function () {
    return view('contact');
})->name('contact-us');
Route::get('/about', function () {
    return view('about-us');
})->name('about-us');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/{product}/info', [BidController::class, 'getProductInfo'])->name('products.info');
Route::get('/category', [HomeController::class, 'category'])->name('products.category');
Route::get('/search', [HomeController::class, 'search'])->name('products.search');
Route::get('/search-suggestions', [ProductController::class, 'searchSuggestions'])->name('search.suggestions');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AuthController::class, 'admin.dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AuthController::class, 'admin.users'])->name('admin.users');
    Route::get('/admin/products', [AuthController::class, 'admin.products'])->name('admin.products');
    Route::get('/admin/reports', [AuthController::class, 'admin.reports'])->name('admin.reports');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/account', [UserController::class, 'edit'])->name('account');
    Route::put('/account/edit', [UserController::class, 'update'])->name('account.update');
    Route::put('/account/password/edit', [UserController::class, 'updatePassword'])->name('account.updatePassword');
    Route::delete('/account/delete', [UserController::class, 'destroy'])->name('account.destroy');

    Route::get('/compare', [ProductController::class, 'compare'])->name('products.compare');
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/product', [ProductController::class, 'store'])->name('products.store');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/product/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::post('/product/{product}/watchlist', [WatchlistController::class, 'toggle'])->name('products.watchlist');
    Route::post('/product/{product}/bid', [BidController::class, 'placeBid'])->name('products.bid');

    Route::get('/product/{product}/report', [ProductReportController::class, 'show'])->name('report.index');
    Route::post('/product/{product}/report', [ProductReportController::class, 'store'])->name('report.store');

    Route::get('/cart', [TransactionController::class, 'index'])->name('cart');
    Route::get('/cart/checkout', [TransactionController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/checkout', [TransactionController::class, 'saveShippingAddres'])->name('cart.checkout');

    Route::get('/account/chat/{user?}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/account/chat/{user}', [ChatController::class, 'send'])->name('chat.send');

    Route::get('/account/watchlist', [WatchlistController::class, 'index'])->name('watchlist.index');
    Route::get('/account/withdraw', [WithdrawController::class, 'index'])->name('withdraw.index');
    Route::post('/account/withdraw', [WithdrawController::class, 'request'])->name('withdraw.request');
    Route::get('/account/transaction', [TransactionController::class, 'history'])->name('transaction.index');

    Route::get('/account/transaction/{transaction}/report', [TransactionReportController::class, 'show'])->name('transaction.report.index');
    Route::post('/account/transaction/{transaction}/report', [TransactionReportController::class, 'store'])->name('transaction.report.store');

    Route::middleware(['admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
    });
});
