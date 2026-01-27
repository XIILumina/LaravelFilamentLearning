<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()
            ->with(['community', 'likes', 'comments'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(20);

        $stats = [
            'posts' => $user->posts()->count(),
            'comments' => $user->comments()->count(),
            'communities' => $user->subscribedCommunities()->count(),
            'likes_received' => $user->posts()->withCount('likes')->get()->sum('likes_count'),
        ];

        return view('profile.show', compact('user', 'posts', 'stats'));
    }

    public function myProfile()
    {
        return $this->show(Auth::user());
    }
}
