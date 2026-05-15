<?php
// app/Http/Controllers/SupportBubbleController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\SupportMessage;

class SupportBubbleController extends Controller
{
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:5|max:5000',
        ]);

        try {
            // Save to database
            $message = SupportMessage::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'status' => 'Pending'
            ]);

            // Send email notification
            $this->sendEmailNotification($validated);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully! We will get back to you soon.',
                'ticket_id' => $message->id
            ], 200);

        } catch (\Exception $e) {
            Log::error('Support message error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.'
            ], 500);
        }
    }

    private function sendEmailNotification(array $data)
    {
        $adminEmail = config('support-bubble.mail.to');
        
        if (!$adminEmail || $adminEmail === 'admin@example.com') {
            return;
        }

        try {
            Mail::raw(
                "New Support Message\n\n" .
                "Name: {$data['name']}\n" .
                "Email: {$data['email']}\n" .
                "Subject: {$data['subject']}\n" .
                "Message:\n{$data['message']}\n\n" .
                "Please check the admin dashboard to resolve this ticket.",
                function ($mail) use ($adminEmail) {
                    $mail->to($adminEmail)
                         ->subject('[Support] ' . substr($data['subject'], 0, 50));
                }
            );
        } catch (\Exception $e) {
            Log::warning('Failed to send email notification: ' . $e->getMessage());
        }
    }
}