<?php

use App\Http\Controllers\Clients\AccountController;
use App\Http\Controllers\Clients\AuthController;
use App\Http\Controllers\Clients\CartController;
use App\Http\Controllers\Clients\ChatController;
use App\Http\Controllers\Clients\CheckoutController;
use App\Http\Controllers\Clients\ContactController;
use App\Http\Controllers\Clients\HomeController;
use App\Http\Controllers\Clients\OrderController;
use App\Http\Controllers\Clients\PasswordController;
use App\Http\Controllers\Clients\ProductController;
use App\Http\Controllers\Clients\RecipeController;
use App\Http\Controllers\Clients\ReviewController;
use App\Http\Controllers\Clients\SearchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function () {
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

    // Routes cho authentication - dùng middleware 'guest' để chỉ cho phép khi chưa login
    Route::middleware('guest')->group(function () {
        Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AuthController::class, 'register']);

        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);

        // quên mật khẩu
        Route::get('/forgot-password', [PasswordController::class, 'showForgotForm'])
            ->name('password.request');

        Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])
            ->name('password.email');

        // đặt lại mật khẩu
        Route::get('/dat-lai-mat-khau/{token}', [PasswordController::class, 'showResetForm'])
            ->name('password.reset');

        Route::post('/dat-lai-mat-khau', [PasswordController::class, 'resetPassword'])
            ->name('password.update');

    });

    Route::get('/activate/{token}', [AuthController::class, 'activate'])->name('activate.account');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware(['auth.custom'])->group(function () {
        Route::prefix('account')->group(function () {
            Route::get('/', [AccountController::class, 'index'])->name('account');
            Route::post('/update', [AccountController::class, 'update'])->name('account.update');
            Route::put('/update', [AccountController::class, 'update']);

            Route::post('/change-password', [AccountController::class, 'changePassword'])->name('account.change-password');

            Route::post('addresses', [AccountController::class, 'addAddress'])->name('account.addresses.add');
            Route::put('addresses/{id}', [AccountController::class, 'updatePrimaryAddress'])->name('account.addresses.update');
            Route::delete('addresses/{id}', [AccountController::class, 'deleteAddress'])->name('account.addresses.delete');



        });
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::get('/checkout/get-address', [CheckoutController::class, 'getAddress']);

        Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');


        Route::get('/checkout/get-shipping-fee', [CheckoutController::class, 'getShippingFee'])->name('checkout.getShippingFee');


        //thanh toán VNPay
        Route::get('/checkout/vnpay-return', [CheckoutController::class, 'vnpayReturn'])->name('vnpay.return');


        Route::get('/order/{id}', [OrderController::class, 'showOrder'])->name('order.show');

        //hủy đơn hàng
        Route::post('/order/{id}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

        //đánh giá sản phẩm
        Route::post('/review', [ReviewController::class, 'createReview']);
        //load đánh giá sản phẩm
        Route::get('/review/{product}', [ReviewController::class, 'index']);



    });

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/products/filter', [ProductController::class, 'filter'])->name('products.filter');

    // Detail Product
    Route::get('/product/{slug}', [ProductController::class, 'detail'])->name('product.detail');

    Route::get('/products/category/{id}', [ProductController::class, 'filterByCategory'])->name('products.byCategory');



    // thêm sản phẩm vào giỏ
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    // xóa giỏ hàng
    Route::post('/cart/remove', [CartController::class, 'removeFormMiniCart'])->name('cart.remove');
    // Xe đẩy trên cùng
    Route::get('/mini-cart', [CartController::class, 'loadMiniCart'])->name('cart.mini');


    // Xu ly trang gio hang
    Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.index');
    Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
    Route::post('/cart/remove-cart', [CartController::class, 'removeCartItem'])->name('cart.remove');


    //Handle Contact
    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    //gửi liên hệ
    Route::post('/contact', [ContactController::class, 'sendContact'])->name('contact');


    Route::get('/search', [SearchController::class, 'index'])->name('search');


    //chatbox
    Route::get('/chat/messages', [ChatController::class, 'fetchMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);



    // Trang xem món ăn
    Route::get('/menu', [RecipeController::class, 'index'])->name('client.recipes');

    // ajax lấy nguyên liệu
    Route::post('/get-recipe-ingredients', [RecipeController::class, 'getIngredients'])->name('get.recipe.ingredients');



    // Routes yêu cầu login (middleware 'auth') - giữ dashboard và profile từ Breeze
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');



        Route::post('/order/{id}/complete', [OrderController::class, 'completeOrder'])->name('order.complete');



    });

});


require __DIR__.'/admin.php';
