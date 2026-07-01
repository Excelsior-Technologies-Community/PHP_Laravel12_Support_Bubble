<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupportMessage;
use Illuminate\Support\Facades\Mail;

class SupportBubbleController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'category' => 'required|in:Bug,Billing,Inquiry',
            'attachment' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('support_attachments', 'public');
        }

        $supportMessage = SupportMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'category' => $request->category,
            'status' => 'Pending',
            'attachment_path' => $attachmentPath,
            'is_notified' => false
        ]);

        Mail::send('emails.support_notification', ['support' => $supportMessage], function ($mail) use ($request, $attachmentPath) {
            $mail->to('admin@gmail.com')
                 ->subject('New Support Ticket: ' . $request->subject);
            
            if ($attachmentPath) {
                $mail->attach(storage_path('app/public/' . $attachmentPath));
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Your support ticket has been submitted successfully.'
        ]);
    }

    public function getUnreadCount()
    {
        $unreadMessages = SupportMessage::where('is_notified', false)->get();
        
        if ($unreadMessages->count() > 0) {
            SupportMessage::whereIn('id', $unreadMessages->pluck('id'))->update(['is_notified' => true]);
            return response()->json(['new_messages' => true, 'count' => $unreadMessages->count()]);
        }

        return response()->json(['new_messages' => false, 'count' => 0]);
    }
}