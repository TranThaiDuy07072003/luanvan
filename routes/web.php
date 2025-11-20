<?php

use App\Http\Controllers\Clients\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Clients\AuthController;  // Use cho AuthController custom
use App\Http\Controllers\Clients\PasswordController;  // Use cho ProfileController từ Breeze (nếu cần)
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\AccountController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\ProductController;

// Routes public (không yêu cầu login) - giữ nguyên custom của bạn
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('user.pages.about');
})->name('about');

Route::get('/service', function () {
    return view('user.pages.service');
})->name('service');

Route::get('/faq', function () {
    return view('user.pages.faq');
})->name('faq');

// Routes cho authentication - dùng middleware 'guest' để chỉ cho phép khi chưa login (uncomment và thêm route register của bạn)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);


    // === QUÊN MẬT KHẨU ===
    Route::get('/quen-mat-khau', [PasswordController::class, 'showForgotForm'])
        ->name('password.request');

    Route::post('/quen-mat-khau', [PasswordController::class, 'sendResetLink'])
        ->name('password.email');

    // === ĐẶT LẠI MẬT KHẨU ===
    Route::get('/dat-lai-mat-khau/{token}', [PasswordController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/dat-lai-mat-khau', [PasswordController::class, 'resetPassword'])
        ->name('password.update');

});

Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate.account');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');



Route::middleware(['auth.custom'])->group(function () {
    Route::prefix('account')->group(function(){
        Route::get('/', [AccountController::class, 'index'])->name('account');
        Route::post('/update', [AccountController::class, 'update'])->name('account.update');
        Route::put('/update', [AccountController::class, 'update']);


        Route::post('/change-password', [AccountController::class, 'changePassword'])->name('account.change-password');


        Route::post('addresses', [AccountController::class, 'addAddress'])->name('account.addresses.add');
        Route::put('addresses/{id}', [AccountController::class, 'updatePrimaryAddress'])->name('account.addresses.update');
        Route::delete('addresses/{id}', [AccountController::class, 'deleteAddress'])->name('account.addresses.delete');

    });


});


Route::get('/products', [ProductController::class, 'index'])->name('products.index');

Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');





// Detail Product
Route::get('/product/{slug}', [ProductController::class, 'detail'])->name('product.detail');



// Handle Cart
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

//xóa giỏ hàng
Route::post('/cart/remove', [CartController::class, 'removeFormMiniCart'])->name('cart.remove');

//Xe đẩy trên cùng
Route::get('/mini-cart', [CartController::class, 'loadMiniCart'])->name('cart.mini');







// Routes yêu cầu login (middleware 'auth') - giữ dashboard và profile từ Breeze
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');  // Có thể thêm 'verified' nếu dùng email verification: ->middleware('verified')

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

    // Thêm route cho logout (POST để bảo mật, tránh logout bằng GET)
    // Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Comment require auth.php để tránh xung đột với custom routes (uncomment nếu cần full Breeze features như forgot password)
// require __DIR__.'/auth.php';
