<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function index()
    {
        return view('connections.index');
    }

    public function request(User $user)
    {
        $existingFriendship = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', auth()->id())
                  ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', auth()->id());
        })->first();

        if ($existingFriendship) {
            return back()->with('error', 'Friend request already exists or you are already friends.');
        }

        Friendship::create([
            'user_id' => auth()->id(),
            'friend_id' => $user->id,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Friend request sent!');
    }

    public function accept(User $user)
    {
        $friendship = Friendship::where('user_id', $user->id)
            ->where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $friendship->update(['status' => 'accepted']);

        return back()->with('success', 'Friend request accepted!');
    }

    public function decline(User $user)
    {
        $friendship = Friendship::where('user_id', $user->id)
            ->where('friend_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        $friendship->delete();

        return back()->with('success', 'Friend request declined.');
    }

    public function unfriend(User $user)
    {
        Friendship::where(function ($query) use ($user) {
            $query->where('user_id', auth()->id())
                  ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', auth()->id());
        })->delete();

        return back()->with('success', 'Friend removed.');
    }
}

