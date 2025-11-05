<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class GameController extends Controller
{
   public function index(Request $request)
{
    $query = Game::query()->with(['genres', 'platforms', 'developer']);

    if ($search = $request->get('search')) {
        $query->where('title', 'like', "%{$search}%")
              ->orWhereHas('genres', fn($q) => $q->where('name', 'like', "%{$search}%"));
    }

    $games = $query->paginate(9);

    return view('games.index', compact('games'));
}
}
