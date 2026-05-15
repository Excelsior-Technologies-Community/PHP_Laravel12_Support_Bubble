<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportBubbleController;
use App\Models\SupportMessage;

Route::get('/', function () {
    return view('welcome');
});

// Support form submission
Route::post('/support-bubble', [SupportBubbleController::class, 'submit'])
    ->name('supportBubble.submit');

// Admin dashboard
Route::get('/admin/support-messages', function () {
    $messages = SupportMessage::latest()->get();
    return view('admin.support-messages', compact('messages'));
})->name('admin.messages');

// Resolve message
Route::get('/resolve/{id}', function ($id) {
    $message = SupportMessage::findOrFail($id);
    $message->status = 'Resolved';
    $message->save();
    return redirect()->back()->with('success', 'Message marked as resolved!');
})->name('resolve.message');