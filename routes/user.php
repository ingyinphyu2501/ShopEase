<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ProfileController;

Route::group(['prefix' => 'user', 'middleware' => 'user'], function() {

    Route::get('home',[UserController::class, 'userHome'])->name('userHome');

    Route::get('chat', [ChatbotController::class, 'chat'])->name('userChatbot');

    Route::group(['prefix' => 'product'], function() {
        Route::get('details/{id}',[UserController::class, 'productDetails'])->name('userProductDetails');
        Route::post('rating',[UserController::class, 'rating'])->name('userProductRating');
    });

    Route::group(['prefix' => 'cart'], function() {
        Route::get('page',[UserController::class, 'cartPage'])->name('userCartPage');
        Route::post('addToCart',[UserController::class, 'addToCart'])->name('userAddToCart');
        Route::get('delete',[UserController::class, 'delete'])->name('userCartDelete');
    });

    Route::group(['prefix' => 'order'], function() {
        Route::get('temp',[UserController::class, 'temp'])->name('userOrderTemp');
        Route::get('payment',[UserController::class, 'paymentPage'])->name('userOrderPayment');
        Route::post('create',[UserController::class, 'create'])->name('userOrderCreate');
        Route::get('list',[UserController::class, 'list'])->name('userOrderList');
    });

    Route::group(['prefix' => 'comment'], function() {
        Route::post('create',[UserController::class, 'commentCreate'])->name('userCommentCreate');
        Route::get('delete/{id}',[UserController::class, 'commentDelete'])->name('userCommentDelete');
    });

    Route::group(['prefix' => 'contact'], function() {
        Route::get('page',[UserController::class, 'contactPage'])->name('userContactPage');
        Route::post('create',[UserController::class, 'contactCreate'])->name('userContactCreate');
    });

    Route::group(['prefix' => 'profile'], function() {
        Route::get('edit',[ProfileController::class, 'edit'])->name('userProfileEdit');
        Route::post('update',[ProfileController::class, 'update'])->name('userProfileUpdate');
        Route::get('change/password',[ProfileController::class, 'changePasswordPage'])->name('userChangePasswordPage');
        Route::post('change/password',[ProfileController::class, 'changePassword'])->name('userChangePassword');
    });



});
