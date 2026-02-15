<?php

use App\Http\Controllers\OfflinePaymentController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Public: callback/webhook and success redirect (payment gateways redirect users here)
Route::controller(PaymentController::class)->group(function () {
    Route::get('payment/success/{identifier?}', 'payment_success')->name('payment.success');
    Route::get('payment/make/{identifier}/status', 'paytm_paymentCallback')->name('payment.status');
});

// Protected: user-triggered payment/subscription actions (auth + verified)
Route::controller(PaymentController::class)->middleware(['auth', 'verified'])->group(function () {
    Route::get('payment/{id}', 'index')->name('payment');
    Route::get('payment/show_payment_gateway_by_ajax/{identifier}', 'show_payment_gateway_by_ajax')->name('payment.show_payment_gateway_by_ajax');
    Route::get('payment/create/{identifier}', 'payment_create')->name('payment.create');
    Route::get('free-subscription/{id}', 'freeSubscription')->name('free_subscription');

    // razor pay
    Route::post('payment/{identifier}/order', 'payment_razorpay')->name('razorpay.order');

    // paytm pay
    Route::get('payment/make/paytm/order', 'make_paytm_order')->name('make.paytm.order');

    Route::get('payment/web_redirect_to_pay_fee', 'webRedirectToPayFee')->name('payment.web_redirect_to_pay_fee');
});