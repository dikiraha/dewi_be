<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Website\AuthController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\VendorController;
use App\Http\Controllers\Website\DepartmentController;
use App\Http\Controllers\Website\UserController;
use App\Http\Controllers\Website\SettingController;
use App\Http\Controllers\Website\RoleController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['namespace' => 'Website', 'as' => 'website.'], function() {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('showLoginForm');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

    Route::middleware(['auth.web'])->group(function () {
        Route::get('/', [HomeController::class, 'home'])->name('home');
        Route::get('/home_ajax', [HomeController::class, 'home_ajax'])->name('home_ajax');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::group(['prefix' => 'vendor', 'as' => 'vendor.'], function () {
            Route::get('/list', [VendorController::class, 'list'])->name('list');
            Route::get('/list_ajax', [VendorController::class, 'list_ajax'])->name('list_ajax');
            Route::get('/create', [VendorController::class, 'create'])->name('create');
            Route::post('/store', [VendorController::class, 'store'])->name('store');
            Route::get('/edit/{uuid}', [VendorController::class, 'edit'])->name('edit');
            Route::post('/update/{uuid}', [VendorController::class, 'update'])->name('update');
            Route::post('destroy', [VendorController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'department', 'as' => 'department.'], function () {
            Route::get('/list', [DepartmentController::class, 'list'])->name('list');
            Route::get('/list_ajax', [DepartmentController::class, 'list_ajax'])->name('list_ajax');
            Route::get('/create', [DepartmentController::class, 'create'])->name('create');
            Route::post('/store', [DepartmentController::class, 'store'])->name('store');
            Route::get('/edit/{uuid}', [DepartmentController::class, 'edit'])->name('edit');
            Route::post('/update/{uuid}', [DepartmentController::class, 'update'])->name('update');
            Route::post('destroy', [DepartmentController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'role', 'as' => 'role.'], function () {
            Route::get('/list', [RoleController::class, 'list'])->name('list');
            Route::get('/list_ajax', [RoleController::class, 'list_ajax'])->name('list_ajax');
            Route::get('/create', [RoleController::class, 'create'])->name('create');
            Route::post('/store', [RoleController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [RoleController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [RoleController::class, 'update'])->name('update');
            Route::post('destroy', [RoleController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
            Route::get('/list', [UserController::class, 'list'])->name('list');
            Route::get('/list_ajax', [UserController::class, 'list_ajax'])->name('list_ajax');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{uuid}', [UserController::class, 'edit'])->name('edit');
            Route::post('/update/{uuid}', [UserController::class, 'update'])->name('update');
            Route::post('destroy', [UserController::class, 'destroy'])->name('destroy');
        });

        Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
            Route::get('/list', [SettingController::class, 'list'])->name('list');
            Route::get('/list_ajax', [SettingController::class, 'list_ajax'])->name('list_ajax');
            Route::get('/create', [SettingController::class, 'create'])->name('create');
            Route::post('/store', [SettingController::class, 'store'])->name('store');
            Route::get('/edit/{uuid}', [SettingController::class, 'edit'])->name('edit');
            Route::post('/update/{uuid}', [SettingController::class, 'update'])->name('update');
            Route::post('destroy', [SettingController::class, 'destroy'])->name('destroy');
        });
    });
});