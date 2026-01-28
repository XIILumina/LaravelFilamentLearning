<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProfilePost;
use App\Models\ProfilePostComment;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        // Get user stats
        $stats = [
            'posts' => $user->posts()->count(),
            'comments' => $user->comments()->count(),
            'communities' => $user->subscribedCommunities()->count(),
            'likes_received' => $user->posts()->withCount('likes')->get()->sum('likes_count'),
        ];

        // Get recent posts from communities
        $recentPosts = $user->posts()
            ->with(['community'])
            ->withCount(['likes'])
            ->latest()
            ->take(5)
            ->get();

        // Get profile wall posts with author and comments
        $profilePosts = $user->profilePosts()
            ->with(['author', 'comments.user'])
            ->latest()
            ->get();

        return view('profile.show-enhanced', compact('user', 'stats', 'recentPosts', 'profilePosts'));
    }

    public function myProfile()
    {
        return $this->show(Auth::user());
    }

    public function storePost(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        ProfilePost::create([
            'user_id' => $user->id,
            'author_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('user.profile', $user)->with('success', 'Posted successfully!');
    }

    public function deletePost(User $user, ProfilePost $profilePost)
    {
        // Only the post author or profile owner can delete
        if (Auth::id() !== $profilePost->author_id && Auth::id() !== $profilePost->user_id) {
            abort(403);
        }

        $profilePost->delete();

        return redirect()->route('user.profile', $user)->with('success', 'Post deleted!');
    }

    public function storeComment(Request $request, User $user, ProfilePost $profilePost)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        ProfilePostComment::create([
            'profile_post_id' => $profilePost->id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('user.profile', $user)->with('success', 'Comment added!');
    }

    public function deleteComment(User $user, ProfilePost $profilePost, ProfilePostComment $comment)
    {
        // Only the comment author can delete
        if (Auth::id() !== $comment->user_id) {
            abort(403);
        }

        $comment->delete();

        return redirect()->route('user.profile', $user)->with('success', 'Comment deleted!');
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old profile picture if exists
        if ($user->profile_picture) {
            \Storage::disk('public')->delete($user->profile_picture);
        }

        // Store new profile picture
        $path = $request->file('profile_picture')->store('profile-pictures', 'public');

        $user->update(['profile_picture' => $path]);

        return redirect()->back()->with('success', 'Profile picture updated successfully!');
    }

    public function deleteProfilePicture()
    {
        $user = Auth::user();

        if ($user->profile_picture) {
            \Storage::disk('public')->delete($user->profile_picture);
            $user->update(['profile_picture' => null]);
        }

        return redirect()->back()->with('success', 'Profile picture removed successfully!');
    }
}
