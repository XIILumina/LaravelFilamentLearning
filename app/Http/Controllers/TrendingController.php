<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\Post;

class TrendingController extends Controller
{
    public function index()
    {
        // Get trending communities with most subscribers
        $trendingCommunities = Community::where('is_active', true)
            ->withCount('subscribers')
            ->orderBy('subscribers_count', 'desc')
            ->orderBy('post_count', 'desc')
            ->take(20)
            ->get();

        // Get recent popular posts across all communities
        $trendingPosts = Post::whereNotNull('community_id')
            ->withCount(['likes', 'comments'])
            ->with(['user', 'community'])
            ->where('created_at', '>=', now()->subDays(7)) // Last week
            ->orderByRaw('(likes_count + comments_count * 2) DESC')
            ->take(10)
            ->get();

        return view('trending.index', compact('trendingCommunities', 'trendingPosts'));
    }
}
