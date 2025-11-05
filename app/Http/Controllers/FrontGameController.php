<?php

namespace App\Http\Controllers;
use App\Models\Game;

use Illuminate\Http\Request;

class FrontGameController extends Controller
{
    public function index()
    {
        $games = Game::with(['developer', 'genres', 'platforms'])->paginate(9);
        return view('games.index', compact('games'));
    }

    public function show(Game $game)
    {
        $game->load(['developer', 'genres', 'platforms']);
        return view('games.show', compact('game'));
    }
}