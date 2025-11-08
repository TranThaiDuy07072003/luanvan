<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clients\AuthController;  // Use cho AuthController custom
use App\Http\Controllers\ProfileController;  // Use cho ProfileController từ Breeze (nếu cần)

// Routes public (không yêu cầu login) - giữ nguyên custom của bạn
Route::get('/', function () {
    return view('user.pages.home');
});

Route::get('/about', function () {
    return view('user.pages.about');
});

Route::get('/service', function () {
    return view('user.pages.service');
});

Route::get('/faq', function () {
    return view('user.pages.faq');
});

// Routes cho authentication - dùng middleware 'guest' để chỉ cho phép khi chưa login
Route::middleware('guest')->group(function () {
    // Route cho register (giữ nguyên custom, override Breeze nếu có)
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('post-register');

    // Thêm route cho login (hiển thị form và xử lý post)
    Route::get('/login', function () {
        return view('user.pages.login');  // Giả sử bạn có view login.blade.php tương tự register
    })->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('post-login');
});

// Routes yêu cầu login (middleware 'auth') - giữ dashboard và profile từ Breeze
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');  // Có thể thêm 'verified' nếu dùng email verification: ->middleware('verified')

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Thêm route cho logout (POST để bảo mật, tránh logout bằng GET)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Comment require auth.php để tránh xung đột với custom routes (uncomment nếu cần full Breeze features như forgot password)
// require __DIR__.'/auth.php';
