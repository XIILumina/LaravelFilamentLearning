<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function toggle(Request $request, Post $post)
    {
        $request->validate([
            'is_like' => 'required|boolean'
        ]);

        $isLike = $request->get('is_like');
        $userId = Auth::id();

        // Check if user already liked/disliked this post
        $existingLike = PostLike::where('user_id', $userId)
            ->where('post_id', $post->id)
            ->first();

        if ($existingLike) {
            if ($existingLike->is_like == $isLike) {
                // Same reaction - remove it
                $existingLike->delete();
                
                // Update counters
                if ($isLike) {
                    $post->decrement('likes_count');
                } else {
                    $post->decrement('dislikes_count');
                }
                
                $action = 'removed';
            } else {
                // Different reaction - update it
                $existingLike->update(['is_like' => $isLike]);
                
                // Update counters
                if ($isLike) {
                    $post->increment('likes_count');
                    $post->decrement('dislikes_count');
                } else {
                    $post->increment('dislikes_count');
                    $post->decrement('likes_count');
                }
                
                $action = 'updated';
            }
        } else {
            // New reaction
            PostLike::create([
                'user_id' => $userId,
                'post_id' => $post->id,
                'is_like' => $isLike
            ]);
            
            // Update counters
            if ($isLike) {
                $post->increment('likes_count');
            } else {
                $post->increment('dislikes_count');
            }
            
            $action = 'added';
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'action' => $action,
                'likes_count' => $post->fresh()->likes_count,
                'dislikes_count' => $post->fresh()->dislikes_count,
                'user_liked' => $post->fresh()->isLikedBy(Auth::user()),
                'user_disliked' => $post->fresh()->isDislikedBy(Auth::user()),
            ]);
        }

        return redirect()->back();
    }
}
