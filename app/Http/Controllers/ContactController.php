<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Notifications\NewContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Save to database
        try {
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'pending',
            ]);

            // Notify admin users about the new contact message
            $adminUsers = User::where('email', 'admin@gamesite.com')->get();
            if ($adminUsers->isNotEmpty()) {
                Notification::send($adminUsers, new NewContactMessage($contact));
            }
            
            // Log the contact submission
            Log::info('Contact form submission saved', [
                'contact_id' => $contact->id,
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            return redirect()
                ->route('contact.index')
                ->with('success', 'Thank you for your message! We\'ll get back to you soon.');
                
        } catch (\Exception $e) {
            Log::error('Contact form error: ' . $e->getMessage());
            
            return redirect()
                ->back()
                ->with('error', 'Sorry, there was an error sending your message. Please try again later.')
                ->withInput();
        }
    }
}
