<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RecipeController;
use App\Http\Middleware\DefaultAdminData;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::middleware(['check.auth.admin'])->group(function () {

        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

    });


    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');



    Route::middleware(['auth.custom', DefaultAdminData::class])->group(function () {
        //làm dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');



        //quản lý profile admin
        Route::get('/profile', [AccountController::class, 'index'])->name('admin.profile');
        //update profile
        Route::post('/profile/update', [AccountController::class, 'updateProfile']);

        //làm thông báo cho admin
        Route::get('/notifications', [NotificationController::class, 'index'])->name('admin.notifications.index');

        //đánh dấu thông báo đã đọc
        Route::post('/notification/update', [NotificationController::class, 'update']);


        Route::middleware(['permission:manager_users'])->group(function(){
            Route::get('/users' , [UsersController::class, 'index'])->name('admin.users.index');
            Route::post('/user/upgrade' , [UsersController::class, 'upgrade']);

            Route::post('/user/change-status', [UsersController::class, 'changeStatus'])->name('admin.users.status');
        });


        Route::middleware(['permission:manager_categories'])->group(function(){
            Route::get('/categories/add' , [CategoryController::class, 'showFormAddCate'])->name('admin.categories.add');
            Route::post('/categories/add', [CategoryController::class, 'addCategory'])->name('admin.categories.add');

            Route::get('/categories' , [CategoryController::class, 'index'])->name('admin.categories.index');
            Route::post('/categories/update', [CategoryController::class, 'updateCategory']);
            Route::post('/categories/delete', [CategoryController::class, 'deleteCategory']);
        });



        Route::middleware(['permission:manager_products'])->group(function(){
            Route::get('/product/add' , [ProductController::class, 'showFormAddProduct'])->name('admin.product.add');
            Route::post('/product/add', [ProductController::class, 'addProduct'])->name('admin.product.add');

            Route::get('/products' , [ProductController::class, 'index'])->name('admin.products.index');
            Route::post('/product/update', [ProductController::class, 'updateProduct']);
            Route::post('/product/delete', [ProductController::class, 'deleteProduct']);
        });


        // ROUTE QUẢN LÝ MÓN ĂN (RECIPES)
        // (Tạm thời chưa phân quyền permission, ai login admin cũng vào được)
        Route::group(['prefix' => 'recipes'], function () {
            Route::get('/', [RecipeController::class, 'index'])->name('admin.recipes.index');
            Route::get('/add', [RecipeController::class, 'create'])->name('admin.recipes.add');
            Route::post('/add', [RecipeController::class, 'store']);

            Route::post('/update', [RecipeController::class, 'update']);
            Route::post('/delete', [RecipeController::class, 'destroy'])->name('admin.recipes.delete');

            // Route Ajax tìm kiếm sản phẩm cho Select2
            Route::get('/search-products', [RecipeController::class, 'searchProducts'])->name('admin.recipes.search_products');
        });





        Route::middleware(['permission:manager_orders'])->group(function(){
            Route::get('/orders' , [OrderController::class, 'index'])->name('admin.orders.index');

            Route::post('/order/confirm', [OrderController::class, 'confirmOrder']);

            //Xem chi tiết đơn mà khách đặt, sau đó mình gửi hóa đơn cho khách nếu khách cần
            Route::get('/order-detail/{id}' , [OrderController::class, 'showOrderDetail'])->name('admin.order-detail');


            //gửi qua email cái hóa đơn cho khách
            Route::post('/order-detail/send-invoice', [OrderController::class, 'sendMailInvoice']);


            //Admin hủy đơn hàng
            Route::post('/order-detail/cancel-order', [OrderController::class, 'cancelOrder']);
        });




        Route::middleware(['permission:manager_contacts'])->group(function(){
            Route::get('/contact' , [ContactController::class, 'index'])->name('admin.contacts.index');

            //nút gửi trong phần ck-editor
            Route::post('/contact/reply' , [ContactController::class, 'replyContact']);


        });


    });




    // Route Demo
    Route::get('/demo-category', function () {
        return view('admin.pages.demo-add');
    });
    Route::post('/demo-category', [CategoryController::class, 'demoStore'])->name('demo.store');



});

