<?php

use App\Http\Controllers\AIContentController;
use Illuminate\Support\Facades\Route;


Route::post('/ai/suggest', [AIContentController::class, 'generateContent']);
