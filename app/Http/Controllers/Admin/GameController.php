<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Genre;
use App\Models\Developer;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display all games.
     */
    public function index(Request $request)
    {
        $query = Game::with('developer', 'genres');

        // Search games
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', "%{$search}%");
        }

        // Filter by genre
        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) {
                $q->where('id', request('genre'));
            });
        }

        $games = $query->paginate(15);
        $genres = Genre::all();

        return view('admin.games.index', compact('games', 'genres'));
    }

    /**
     * Show game edit form.
     */
    public function edit(Game $game)
    {
        $developers = Developer::all();
        $genres = Genre::all();

        return view('admin.games.edit', compact('game', 'developers', 'genres'));
    }

    /**
     * Update game.
     */
    public function update(Request $request, Game $game)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:10',
            'developer_id' => 'nullable|exists:developers,id',
            'genres' => 'nullable|array'
        ]);

        $game->update($request->except('genres'));

        if ($request->has('genres')) {
            $game->genres()->sync($request->get('genres'));
        }

        return redirect()->route('admin.games.index')
            ->with('success', 'Game updated successfully');
    }
}
