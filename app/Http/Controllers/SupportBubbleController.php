<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\SupportMessage;

class SupportBubbleController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'email' => 'required|email',

            'subject' => 'required',

            'message' => 'required',

        ]);

        // SAVE MESSAGE TO DATABASE

        SupportMessage::create([

            'name' => $request->name,

            'email' => $request->email,

            'subject' => $request->subject,

            'message' => $request->message,

            'status' => 'Pending'

        ]);

        // SEND EMAIL

        Mail::raw(

            "Name: {$request->name}\n
            Email: {$request->email}\n
            Subject: {$request->subject}\n
            Message: {$request->message}",

            function ($mail) {

                $mail->to(config('support-bubble.mail.to'))
                     ->subject('Support Bubble Message');
            }

        );

        return response()->json([

            'success' => true,

            'message' => 'Message sent successfully'

        ]);
    }
}