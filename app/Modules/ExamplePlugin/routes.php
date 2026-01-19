<?php

use Illuminate\Support\Facades\Route;
use App\Modules\ExamplePlugin\Controllers\ExampleController;

Route::middleware(['web'])->group(function () {
    Route::get('/plugin/example', [ExampleController::class, 'index']);
});
