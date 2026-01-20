<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Game;
use App\Models\Community;

class AnalyticsController extends Controller
{
    /**
     * Display platform analytics and statistics.
     */
    public function index()
    {
        // User statistics
        $totalUsers = User::count();
        $admins = User::where('role', 'admin')->count();
        $regularUsers = User::where('role', 'user')->count();
        $newUsersThisMonth = User::where('created_at', '>=', now()->startOfMonth())->count();

        // Content statistics
        $totalPosts = Post::count();
        $postsThisMonth = Post::where('created_at', '>=', now()->startOfMonth())->count();
        $totalGames = Game::count();
        $activeCommunities = Community::where('is_active', true)->count();

        // Engagement metrics
        $avgPostsPerUser = $totalUsers > 0 ? round($totalPosts / $totalUsers, 2) : 0;
        $topAuthors = Post::selectRaw('user_id, count(*) as post_count')
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('post_count')
            ->limit(5)
            ->get();

        return view('admin.analytics.index', compact(
            'totalUsers', 'admins', 'regularUsers', 'newUsersThisMonth',
            'totalPosts', 'postsThisMonth', 'totalGames', 'activeCommunities',
            'avgPostsPerUser', 'topAuthors'
        ));
    }
}
