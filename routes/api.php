<?php

use App\Http\Controllers\ProfileVoucherController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();

})->middleware('auth:sanctum');

Route::get('/user/reseller', [ResellerController::class, 'index'])->name('resellers.index');
    Route::get('/user/reseller/create', [ResellerController::class, 'create'])->name('resellers.create');
    Route::post('/user/reseller/store', [ResellerController::class, 'store'])->name('resellers.store');
    Route::get('/user/reseller/{id}/edit', [ResellerController::class, 'edit'])->name('resellers.edit');
    Route::put('/user/reseller/{id}', [ResellerController::class, 'update'])->name('resellers.update');
    Route::delete('/user/reseller/{id}', [ResellerController::class, 'destroy'])->name('resellers.delete');

    Route::get('/user/voucher', [ProfileVoucherController::class, 'index'])->name('voucher.index');
    Route::get('/user/voucher/create', [ProfileVoucherController::class, 'create'])->name('voucher.create');
    Route::post('/user/voucher/store', [ProfileVoucherController::class, 'store'])->name('voucher.store');
    Route::get('/user/voucher/{id}/edit', [ProfileVoucherController::class, 'edit'])->name('voucher.edit');
    Route::put('/user/voucher/{id}', [ProfileVoucherController::class, 'update'])->name('voucher.update');
    Route::delete('/user/voucher/{id}', [ProfileVoucherController::class, 'destroy'])->name('voucher.delete');

    // // Subscription
    Route::get('/subs', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::post('/subs', [SubscriptionController::class, 'store'])->name('subscription.store');

    

