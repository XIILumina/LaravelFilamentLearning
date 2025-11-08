<?php

namespace App\Http\Controllers;

use App\Models\Community;
use App\Models\Post;
use App\Models\CommunitySubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::with(['game', 'subscribers'])
            ->where('is_active', true)
            ->withCount(['posts', 'subscribers'])
            ->orderBy('subscriber_count', 'desc')
            ->paginate(12);

        return view('communities.index', compact('communities'));
    }

    public function show(Community $community)
    {
        if (!$community->is_active) {
            abort(404);
        }

        $community->load(['game', 'subscribers']);
        
        $posts = $community->posts()
            ->with(['user', 'game', 'community'])
            ->withCount(['comments', 'likes'])
            ->latest()
            ->paginate(10);

        $isSubscribed = Auth::check() ? $community->isSubscribedBy(Auth::user()) : false;
        $isModerator = Auth::check() ? $community->isModeratedBy(Auth::user()) : false;

        return view('communities.show', compact('community', 'posts', 'isSubscribed', 'isModerator'));
    }

    public function showPost(Community $community, Post $post)
    {
        if (!$community->is_active || $post->community_id !== $community->id) {
            abort(404);
        }

        $post->load(['user', 'game', 'community', 'comments.user', 'comments.replies.user']);

        return view('communities.post', compact('community', 'post'));
    }

    public function subscribe(Request $request, Community $community)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if ($community->isSubscribedBy($user)) {
            return redirect()->back()->with('error', 'You are already subscribed to this community.');
        }

        CommunitySubscription::create([
            'user_id' => $user->id,
            'community_id' => $community->id,
            'email_notifications' => $request->boolean('email_notifications', true),
            'push_notifications' => $request->boolean('push_notifications', true),
        ]);

        return redirect()->back()->with('success', 'Successfully subscribed to ' . $community->name . '!');
    }

    public function unsubscribe(Community $community)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        $subscription = CommunitySubscription::where('user_id', $user->id)
            ->where('community_id', $community->id)
            ->first();

        if (!$subscription) {
            return redirect()->back()->with('error', 'You are not subscribed to this community.');
        }

        $subscription->delete();

        return redirect()->back()->with('success', 'Successfully unsubscribed from ' . $community->name . '.');
    }

    public function updateNotifications(Request $request, Community $community)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $request->validate([
            'email_notifications' => 'boolean',
            'push_notifications' => 'boolean',
        ]);

        $user = Auth::user();
        
        $subscription = CommunitySubscription::where('user_id', $user->id)
            ->where('community_id', $community->id)
            ->first();

        if (!$subscription) {
            return redirect()->back()->with('error', 'You are not subscribed to this community.');
        }

        $subscription->update([
            'email_notifications' => $request->boolean('email_notifications'),
            'push_notifications' => $request->boolean('push_notifications'),
        ]);

        return redirect()->back()->with('success', 'Notification preferences updated!');
    }
}
