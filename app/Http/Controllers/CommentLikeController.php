<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentLikeController extends Controller
{
    public function toggle(Request $request, Comment $comment)
    {
        $request->validate([
            'is_like' => 'required|boolean'
        ]);

        $isLike = $request->get('is_like');
        $userId = Auth::id();

        // Check if user already liked/disliked this comment
        $existingLike = CommentLike::where('user_id', $userId)
            ->where('comment_id', $comment->id)
            ->first();

        if ($existingLike) {
            if ($existingLike->is_like == $isLike) {
                // Same reaction - remove it
                $existingLike->delete();
                
                // Update counters
                if ($isLike) {
                    $comment->decrement('likes_count');
                } else {
                    $comment->decrement('dislikes_count');
                }
                
                $action = 'removed';
            } else {
                // Different reaction - update it
                $existingLike->update(['is_like' => $isLike]);
                
                // Update counters
                if ($isLike) {
                    $comment->increment('likes_count');
                    $comment->decrement('dislikes_count');
                } else {
                    $comment->increment('dislikes_count');
                    $comment->decrement('likes_count');
                }
                
                $action = 'updated';
            }
        } else {
            // New reaction
            CommentLike::create([
                'user_id' => $userId,
                'comment_id' => $comment->id,
                'is_like' => $isLike
            ]);
            
            // Update counters
            if ($isLike) {
                $comment->increment('likes_count');
            } else {
                $comment->increment('dislikes_count');
            }
            
            $action = 'added';
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'action' => $action,
                'likes_count' => $comment->fresh()->likes_count,
                'dislikes_count' => $comment->fresh()->dislikes_count,
                'user_liked' => $comment->fresh()->isLikedBy(Auth::user()),
                'user_disliked' => $comment->fresh()->isDislikedBy(Auth::user()),
            ]);
        }

        return redirect()->back();
    }
}
