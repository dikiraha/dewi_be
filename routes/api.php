<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PurchaseRequisitionController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\DepartmentController;

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);

Route::group(['namespace' => 'Website', 'as' => 'website.'], function() {
    Route::post('/register', [AuthController::class, 'register'])->name('api.register');
    Route::post('/login', [AuthController::class, 'login'])->name('api.login');

    Route::middleware(['auth.api'])->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::group(['prefix' => 'pr', 'as' => 'pr.'], function () {
            Route::post('/store', [PurchaseRequisitionController::class, 'store'])->name('store');
            Route::get('/approval_ajax', [PurchaseRequisitionController::class, 'approval_ajax'])->name('approval_ajax');
            Route::post('/approval', [PurchaseRequisitionController::class, 'approval'])->name('approval');
        });

        // Route::get('/home_ajax', [HomeController::class, 'home_ajax'])->name('home_ajax');

        // Route::group(['prefix' => 'department', 'as' => 'department.'], function () {
        //     Route::get('/list', [DepartmentController::class, 'list'])->name('list');
        //     Route::get('/list_ajax', [DepartmentController::class, 'list_ajax'])->name('list_ajax');
        //     Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        //     Route::post('/store', [DepartmentController::class, 'store'])->name('store');
        //     Route::get('/edit/{uuid}', [DepartmentController::class, 'edit'])->name('edit');
        //     Route::post('/update/{uuid}', [DepartmentController::class, 'update'])->name('update');
        //     Route::post('destroy', [DepartmentController::class, 'destroy'])->name('destroy');
        // });
    });
});

// Route::middleware(['auth.web'])->group(function () {
//     Route::get('/', [HomeController::class, 'home'])->name('home');
// });