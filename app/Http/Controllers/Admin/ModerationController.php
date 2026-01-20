<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class ModerationController extends Controller
{
    /**
     * Display content flagged for moderation.
     */
    public function index(Request $request)
    {
        $posts = Post::query();
        $comments = Comment::query();

        // In a full implementation, you'd have a flagged_at or is_flagged field
        // For now, we'll just show recent posts and comments
        $recentPosts = Post::latest()->paginate(10);
        $recentComments = Comment::latest()->paginate(10);

        return view('admin.moderation.index', compact('recentPosts', 'recentComments'));
    }

    /**
     * Flag or remove a post.
     */
    public function flagPost(Request $request, Post $post)
    {
        $reason = $request->get('reason', 'User reported');
        
        // In a full implementation, this would update a flagged_at timestamp
        // and store the reason

        return redirect()->back()
            ->with('success', 'Post has been flagged for review');
    }

    /**
     * Delete a post for policy violation.
     */
    public function deletePost(Post $post)
    {
        $post->delete();

        return redirect()->back()
            ->with('success', 'Post deleted successfully');
    }

    /**
     * Delete a comment for policy violation.
     */
    public function deleteComment(Comment $comment)
    {
        $post = $comment->post;
        $comment->delete();

        return redirect()->back()
            ->with('success', 'Comment deleted successfully');
    }
}
