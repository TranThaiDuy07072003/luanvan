<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    Route::middleware(['check.auth.admin'])->group(function () {

        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

    });


    Route::get('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');



    Route::middleware(['auth.custom'])->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.pages.dashboard');
        })->name('admin.dashboard');
    });


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
        Route::get('/product/add' , [CategoryController::class, 'showFormAddCate'])->name('admin.product.add');
        Route::post('/product/add', [CategoryController::class, 'addCategory'])->name('admin.product.add');

        Route::get('/products' , [CategoryController::class, 'index'])->name('admin.products.index');
        Route::post('/product/update', [CategoryController::class, 'updateCategory']);
        Route::post('/product/delete', [CategoryController::class, 'deleteCategory']);
    });


});

