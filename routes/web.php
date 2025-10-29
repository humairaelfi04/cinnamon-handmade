<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\RawMaterialController as AdminRawMaterialController;
use App\Http\Controllers\Admin\CustomOptionController as AdminCustomOptionController;
use App\Http\Controllers\ProductBuilderController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TagController as AdminTagController;


/*
|--------------------------------------------------------------------------
| Rute Publik (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/custom-product', [ProductBuilderController::class, 'index'])->name('builder.index');

// Rute untuk melihat keranjang (bisa dilihat oleh guest, tapi akan kosong)
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');

Route::get('/galeri-cerita', [GalleryController::class, 'index'])->name('gallery.index');


/*
|--------------------------------------------------------------------------
| Rute Tamu (Hanya untuk yang belum login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    // --- RUTE LUPA PASSWORD ---
    Route::get('lupa-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('lupa-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');
});


/*
|--------------------------------------------------------------------------
| Rute Terotentikasi (Hanya untuk yang sudah login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // --- RUTE KERANJANG BELANJA (BUTUH LOGIN) ---
    Route::prefix('keranjang')->name('cart.')->group(function () {
        Route::post('/tambah', [CartController::class, 'add'])->name('add');
        Route::post('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::post('/hapus/{id}', [CartController::class, 'remove'])->name('remove');
    });

    // --- RUTE CUSTOM BUILDER (BUTUH LOGIN UNTUK TAMBAH KE KERANJANG) ---
    Route::post('/custom-product/add-to-cart', [ProductBuilderController::class, 'addToCart'])->name('builder.addToCart');

    // Rute Checkout, Pesanan, dll.
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/bayar', [OrderController::class, 'pay'])->name('orders.pay');
    Route::get('/pesanan-saya', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/pesanan/{order}/terima', [OrderController::class, 'receive'])->name('orders.receive');
    Route::get('/review/create/{product}/{order}', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('reviews.store');
});


/*
|--------------------------------------------------------------------------
| Rute Admin (Hanya untuk role 'admin' yang sudah login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('raw-materials', AdminRawMaterialController::class);
    Route::resource('custom-options', AdminCustomOptionController::class);
    Route::resource('tags', AdminTagController::class)->except(['show']);
    Route::get('reports', [ReportController::class, 'sales'])->name('reports.sales');
    Route::post('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('reports/raw-materials/pdf', [ReportController::class, 'rawMaterialsPdf'])->name('reports.raw-materials.pdf');
    Route::get('reports/sales/pdf', [ReportController::class, 'salesPdf'])->name('reports.sales.pdf');
    Route::get('reports/raw-materials', [ReportController::class, 'rawMaterialsReport'])->name('reports.raw-materials');
    Route::resource('reviews', AdminReviewController::class)->only(['index', 'destroy']);
    Route::post('reviews/{review}/toggle-visibility', [AdminReviewController::class, 'toggleVisibility'])->name('reviews.toggleVisibility');
});
