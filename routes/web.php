<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;


Route::get('/user_logout', [HomeController::class, 'logout'])->name('logout_user');


require __DIR__ . '/stripe.php';
require __DIR__.'/stripe_webhook.php';
require __DIR__.'/user.php';
require __DIR__.'/cron_jobs.php';

Route::middleware([
    config('middlewares.auth'),
    'paid.user'
])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});



if (trim(config('app.env')) == config("setting.roles.dev")) {
    URL::forceScheme(config("setting.http"));
}
