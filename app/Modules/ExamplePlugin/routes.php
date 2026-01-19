<?php

use Illuminate\Support\Facades\Route;

Route::prefix('example-plugin')->group(function () {
    Route::get('/', [App\Modules\ExamplePlugin\Controllers\ExampleController::class, 'index']);
});
