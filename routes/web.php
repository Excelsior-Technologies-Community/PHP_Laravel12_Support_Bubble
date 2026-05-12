<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SupportBubbleController;

use App\Models\SupportMessage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return view('welcome');

});


// SUPPORT FORM SUBMIT

Route::post('/support-bubble', [SupportBubbleController::class, 'submit'])
    ->name('supportBubble.submit');


// ADMIN DASHBOARD

Route::get('/admin/support-messages', function () {

    $messages = SupportMessage::latest()->get();

    return view('admin.support-messages', compact('messages'));

});


// RESOLVE MESSAGE

Route::get('/resolve/{id}', function ($id) {

    $message = SupportMessage::findOrFail($id);

    $message->status = 'Resolved';

    $message->save();

    return redirect()->back();

});