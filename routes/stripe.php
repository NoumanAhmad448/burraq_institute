<?php

use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;


Route::middleware(config('middlewares.auth'))->group(function () {

    Route::get('pay-fee', [StripePaymentController::class, 'index'])
        ->name('stripe.payment.page');

    Route::post('pay-fee-intent', [StripePaymentController::class, 'createIntent'])
        ->name('stripe.create.intent');

    Route::post('pay-fee-confirm', [StripePaymentController::class, 'confirm'])
        ->name('stripe.payment.confirm');
});
