<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::prefix('/api')->group(function () {
    Route::post('/url-mappings', [\App\Http\Controllers\Api\UrlMappingsController::class, 'submit']);
});
