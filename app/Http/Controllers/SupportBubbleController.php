<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportBubbleController extends Controller
{
    public function submit(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Send mail (simple)
        Mail::raw(
            "Name: {$request->name}\nEmail: {$request->email}\nSubject: {$request->subject}\nMessage: {$request->message}",
            function ($mail) {
                $mail->to('admin@gmail.com')
                     ->subject('Support Bubble Message');
            }
        );

        return response()->json([
            'success' => true,
            'message' => 'Message sent successfully'
        ]);
    }
}