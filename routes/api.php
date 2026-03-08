<?php

use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;


Route::apiResource('card', CardController::class)
    ->names('api.card');