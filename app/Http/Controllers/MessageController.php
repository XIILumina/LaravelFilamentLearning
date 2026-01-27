<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get unique conversations (users the current user has messaged with)
        $conversations = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->latest()
            ->get()
            ->map(function ($message) use ($user) {
                return $message->sender_id === $user->id ? $message->receiver : $message->sender;
            })
            ->unique('id')
            ->take(20);

        return view('messages.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $currentUser = Auth::user();
        
        // Get all messages between current user and the specified user
        $messages = Message::where(function ($query) use ($currentUser, $user) {
                $query->where('sender_id', $currentUser->id)
                      ->where('receiver_id', $user->id);
            })
            ->orWhere(function ($query) use ($currentUser, $user) {
                $query->where('sender_id', $user->id)
                      ->where('receiver_id', $currentUser->id);
            })
            ->with(['sender', 'receiver'])
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark messages from the other user as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $currentUser->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', compact('user', 'messages'));
    }

    public function store(Request $request, User $receiver)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiver->id,
            'message' => $request->message,
        ]);

        // Create notification for receiver
        \App\Models\Notification::createForUser(
            $receiver->id,
            'message',
            Auth::user()->name . ' sent you a message',
            route('messages.show', Auth::user()),
            ['sender_id' => Auth::id()]
        );

        return redirect()->back()->with('success', 'Message sent!');
    }
}
