<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportBubbleController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/support-bubble', [SupportBubbleController::class, 'submit'])
    ->name('supportBubble.submit');
