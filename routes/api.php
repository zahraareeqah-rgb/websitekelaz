<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuoteController;

Route::get('/v1/quote', [QuoteController::class, 'getRandomQuote']);
