<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;


class WishlistController extends Controller
{
    public function index()
    {
        $games = Auth::user()->wishlistGames()
            ->with(['developer', 'genres', 'platforms'])
            ->orderBy('wishlists.created_at', 'desc')
            ->get();
            
        return view('wishlist.index', compact('games'));
    }

    public function store(Game $game)
    {
        $user = Auth::user();
        
        // Check if already in wishlist to avoid duplicates
        if (!$user->wishlistGames()->where('game_id', $game->id)->exists()) {
            $user->wishlistGames()->attach($game->id);
            return back()->with('success', "'{$game->title}' added to your wishlist!");
        }
        
        return back()->with('info', "'{$game->title}' is already in your wishlist!");
    }

    public function destroy(Game $game)
    {
        Auth::user()->wishlistGames()->detach($game->id);
        return back()->with('success', "'{$game->title}' removed from your wishlist!");
    }
}
