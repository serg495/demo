<?php

declare(strict_types=1);

use App\Api\Http\Controllers\BidsController;
use App\Api\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Here should be API routes.
Route::group([
], function () {
    // public routes
    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::post('events/{event}', EventController::class);
    });
});

Route::group([
    'prefix' => 'bids',
    'as' => 'bids.',
    'middleware' => 'auth:api',
], static function () {
    Route::post('parse', [BidsController::class, 'parse'])->name('parse');
});
