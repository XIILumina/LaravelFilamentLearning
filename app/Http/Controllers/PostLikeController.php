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
        try {
            $request->validate([
                'type' => 'nullable|string|in:like,dislike',
                'is_like' => 'nullable|boolean'
            ]);

            // Support both 'type' (like/dislike) and 'is_like' (true/false) formats
            if ($request->has('type')) {
                $isLike = $request->get('type') === 'like';
            } else {
                $isLike = $request->get('is_like', true);
            }

            $userId = Auth::id();

            if (!$userId) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

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

            if ($request->ajax() || $request->wantsJson()) {
                // Determine current user reaction
                $userReaction = null;
                $currentLike = PostLike::where('user_id', Auth::id())
                    ->where('post_id', $post->id)
                    ->first();
            
                if ($currentLike) {
                    $userReaction = $currentLike->is_like ? 'like' : 'dislike';
                }

                return response()->json([
                    'success' => true,
                    'action' => $action,
                    'likes_count' => $post->fresh()->likes_count ?? 0,
                    'dislikes_count' => $post->fresh()->dislikes_count ?? 0,
                    'user_reaction' => $userReaction,
                    'user_liked' => $post->fresh()->isLikedBy(Auth::user()),
                    'user_disliked' => $post->fresh()->isDislikedBy(Auth::user()),
                ]);
            }

            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error('PostLike toggle error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred',
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'An error occurred while processing your request.');
        }
    }
}
