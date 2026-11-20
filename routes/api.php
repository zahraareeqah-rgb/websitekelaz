<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuoteController;
use App\Http\Controllers\Api\FactController;

Route::get('/v1/quote', [QuoteController::class, 'getRandomQuote']);
Route::get('/v1/fact', [FactController::class, 'getRandomFact']);
