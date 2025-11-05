<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Models\Game;

class GenreController extends Controller
{
    public function index(Request $request)
    {
        $selectedGenre = $request->get('genre');
        $search = $request->get('search');
        
        $genres = Genre::withCount('games')->orderBy('name')->get();
        
        $query = Game::query()->with(['genres', 'platforms', 'developer']);
        
        if ($selectedGenre) {
            $query->whereHas('genres', fn($q) => $q->where('genres.id', $selectedGenre));
        }
    
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('genres', fn($subQ) => $subQ->where('name', 'like', "%{$search}%"))
                  ->orWhereHas('developer', fn($subQ) => $subQ->where('name', 'like', "%{$search}%"));
            });
        }
        
        $games = $query->paginate(9)->withQueryString();
        
        return view('genres.index', compact('genres', 'games', 'selectedGenre', 'search'));
    }
    
    public function show(Genre $genre, Request $request)
    {
        $search = $request->get('search');
        
        // Build the games query for this specific genre
        $query = Game::query()
            ->with(['genres', 'platforms', 'developer'])
            ->whereHas('genres', fn($q) => $q->where('genres.id', $genre->id));
        
        // Filter by search term
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('developer', fn($subQ) => $subQ->where('name', 'like', "%{$search}%"));
            });
        }
        
        $games = $query->paginate(9)->withQueryString();
        
        return view('genres.show', compact('genre', 'games', 'search'));
    }
}
