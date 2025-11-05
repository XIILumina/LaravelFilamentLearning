<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id'
        ]);

        $comment = Comment::create([
            'content' => $request->get('content'),
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'parent_id' => $request->get('parent_id')
        ]);

        // Update post comments count
        $post->increment('comments_count');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user'),
                'message' => 'Comment added successfully!'
            ]);
        }

        return redirect()->route('blog.show', $post)->with('success', 'Comment added successfully!');
    }

    public function update(Request $request, Comment $comment)
    {
        // Check if user owns the comment
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'content' => 'required|string|max:1000'
        ]);

        $comment->update([
            'content' => $request->get('content')
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Comment updated successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        // Check if user owns the comment
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $post = $comment->post;
        
        // Delete all replies first
        $comment->replies()->delete();
        
        // Delete the comment
        $comment->delete();

        // Update post comments count
        $post->decrement('comments_count');

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}
