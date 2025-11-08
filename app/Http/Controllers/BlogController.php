<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Game;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'game', 'community', 'comments.user'])
            ->withCount('comments')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Filter by game
        if ($request->filled('game')) {
            $query->where('game_id', $request->get('game'));
        }

        // Filter by community
        if ($request->filled('community')) {
            $query->where('community_id', $request->get('community'));
        }

        $posts = $query->paginate(10);
        $games = Game::select('id', 'title')->orderBy('title')->get();
        $communities = Community::select('id', 'name', 'hashtag')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('blog.index', compact('posts', 'games', 'communities'));
    }

    public function show(Post $post)
    {
        $post->load([
            'user', 
            'game',
            'community',
            'comments.user',
            'comments.replies.user'
        ]);

        return view('blog.show', compact('post'));
    }

    public function create()
    {
        $games = Game::select('id', 'title')->orderBy('title')->get();
        $communities = Community::select('id', 'name', 'hashtag')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('blog.create', compact('games', 'communities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'game_id' => 'nullable|exists:games,id',
            'community_id' => 'nullable|exists:communities,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('blog-photos', 'public');
        }

        $post = Post::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'game_id' => $request->get('game_id'),
            'community_id' => $request->get('community_id'),
            'photo' => $photoPath,
            'user_id' => Auth::id()
        ]);

        // Update community post count and last post time
        if ($post->community) {
            $post->community->updatePostCount();
        }

        return redirect()->route('blog.index')->with('success', 'Post created successfully!');
    }

    public function edit(Post $post)
    {
        // Check if user owns the post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
        
        $games = Game::select('id', 'title')->orderBy('title')->get();
        $communities = Community::select('id', 'name', 'hashtag')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
        return view('blog.edit', compact('post', 'games', 'communities'));
    }

    public function update(Request $request, Post $post)
    {
        // Check if user owns the post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'game_id' => 'nullable|exists:games,id',
            'community_id' => 'nullable|exists:communities,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $photoPath = $post->photo;
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($post->photo) {
                Storage::disk('public')->delete($post->photo);
            }
            $photoPath = $request->file('photo')->store('blog-photos', 'public');
        }

        $oldCommunityId = $post->community_id;

        $post->update([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'game_id' => $request->get('game_id'),
            'community_id' => $request->get('community_id'),
            'photo' => $photoPath,
        ]);

        // Update post counts for old and new communities
        if ($oldCommunityId !== $post->community_id) {
            if ($oldCommunityId) {
                Community::find($oldCommunityId)?->updatePostCount();
            }
            if ($post->community) {
                $post->community->updatePostCount();
            }
        }

        return redirect()->route('blog.show', $post)->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // Check if user owns the post
        if ($post->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        if ($post->photo) {
            Storage::disk('public')->delete($post->photo);
        }

        $post->delete();

        return redirect()->route('blog.index')->with('success', 'Post deleted successfully!');
    }
}
