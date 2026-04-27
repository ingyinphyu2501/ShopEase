<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;

Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function() {

    Route::get('dashboard',[AdminController::class, 'dashboard'])->name('adminDashboard');

    Route::group(['prefix' => 'category'], function() {
        Route::get('list',[CategoryController::class, 'list'])->name('categoryList');
        Route::post('create',[CategoryController::class, 'create'])->name('categoryCreate');
        Route::get('delete/{id}',[CategoryController::class, 'delete'])->name('categoryDelete');
        Route::get('edit/{id}',[CategoryController::class, 'edit'])->name('categoryEdit');
        Route::post('update/{id}',[CategoryController::class, 'update'])->name('categoryUpdate');
    });

    Route::group(['prefix' => 'product'], function() {
        Route::get('createPage',[ProductController::class, 'createPage'])->name('productCreatePage');
        Route::post('create',[ProductController::class, 'create'])->name('productCreate');
        Route::get('list/{action?}',[ProductController::class, 'list'])->name('productList');
        Route::get('delete/{id}',[ProductController::class, 'delete'])->name('productDelete');
        Route::get('edit/{id}',[ProductController::class, 'edit'])->name('productEdit');
        Route::post('update',[ProductController::class, 'update'])->name('productUpdate');
        Route::get('detail/{id}',[ProductController::class, 'detail'])->name('productDetail');
    });

    Route::group(['prefix' => 'profile'], function() {
        Route::get('edit',[ProfileController::class, 'edit'])->name('profileEdit');
        Route::post('update',[ProfileController::class, 'update'])->name('profileUpdate');

        Route::get('change/password',[ProfileController::class, 'changePasswordPage'])->name('profileChangePasswordPage');
        Route::post('change/password',[ProfileController::class, 'changePassword'])->name('profileChangePassword');
    });

    Route::middleware('superadmin')->group(function() {

        Route::prefix('account')->group(function() {
            Route::get('create/newAdmin',[AdminController::class, 'createAdminPage'])->name('accountNewAdminPage');
            Route::post('create/newAdmin',[AdminController::class, 'createAdmin'])->name('accountNewAdmin');
            Route::get('admin/list',[AdminController::class, 'adminList'])->name('accountAdminList');
            Route::get('admin/delete/{id}',[AdminController::class, 'adminDelete'])->name('adminAccountDelete');
            Route::get('user/list',[AdminController::class, 'userList'])->name('accountUserList');
            Route::get('user/delete/{id}',[AdminController::class, 'userDelete'])->name('userAccountDelete');
        });

        Route::prefix('payment')->group(function() {
            Route::get('list',[PaymentController::class, 'list'])->name('paymentList');
            Route::post('create',[PaymentController::class, 'create'])->name('paymentCreate');
            Route::get('delete/{id}',[PaymentController::class, 'delete'])->name('paymentDelete');
            Route::get('edit/{id}',[PaymentController::class, 'edit'])->name('paymentEdit');
            Route::post('update/{id}',[PaymentController::class, 'update'])->name('paymentUpdate');
        });

    });

    Route::group(['prefix' => 'order'], function() {
        Route::get('list',[OrderController::class, 'list'])->name('adminOrderList');
        Route::get('list/count',[OrderController::class, 'listCount'])->name('adminOrderListCount');
        Route::get('request',[OrderController::class, 'orderRequest'])->name('adminOrderRequest');
        Route::get('details/{orderCode}',[OrderController::class, 'details'])->name('adminOrderDetails');
        Route::get('reject',[OrderController::class, 'reject'])->name('adminOrderReject');
        Route::get('confirm',[OrderController::class, 'confirm'])->name('adminOrderConfirm');
        Route::get('status/change',[OrderController::class, 'statusChange'])->name('adminStatusChange');
    });

});
