<?php

use App\Http\Controllers\intern\DashboardController as InternDashboardController;
use App\Http\Controllers\intern\LoginController as InternLoginController;
use App\Http\Controllers\admin\LoginController as AdminLoginController;
use App\Http\Controllers\admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/intern', function () {
    return view('admin.intern');
});

Route::get('/admin/dokumen', function () {
    return view('admin.dokumen');
});

Route::get('/admin/today', function () {
    return view('admin.presensi.today');
});

// Route::get('/intern', function () {
//     return view('intern.dashboard');
// });

Route::group(['prefix' => 'intern'], function () {
    // Guest Middleware
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [InternLoginController::class, 'index'])->name('intern.login');
        Route::get('/register', [InternLoginController::class, 'register'])->name('intern.register');
        Route::post('/process-register', [InternLoginController::class, 'processRegister'])->name('intern.processRegister');
        Route::post('/authenticate', [InternLoginController::class, 'authenticate'])->name('intern.authenticate');
    });
    // Authenticated MiddleWare
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/logout', [InternLoginController::class, 'logout'])->name('intern.logout');
        Route::get('/dashboard', [InternDashboardController::class, 'index'])->name('intern.dashboard');
    });
});

Route::group(['prefix' => 'admin'], function () {
    // Guest Middleware
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });
    // Authenticated MiddleWare
    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    });
});
