<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupportBubbleController;
use App\Models\SupportMessage;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/support-bubble', [SupportBubbleController::class, 'submit'])->name('supportBubble.submit');
Route::get('/support/unread-count', [SupportBubbleController::class, 'getUnreadCount']);

Route::get('/admin/support-messages', function () {
    $messages = SupportMessage::latest()->get();
    return view('admin.support-messages', compact('messages'));
})->name('admin.messages');

Route::post('/admin/resolve/{id}', function ($id) {
    $message = SupportMessage::findOrFail($id);
    $message->status = 'Resolved';
    $message->save();
    return redirect()->back()->with('success', 'Ticket status updated to Resolved.');
})->name('resolve.message');