<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Developer;
use App\Models\Genre;
use App\Models\Platform;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $developers = Developer::all();
        $genres = Genre::all();
        $platforms = Platform::all();

        // Example 10 games
        Game::factory(10)->create()->each(function ($game) use ($developers, $genres, $platforms) {
            // Assign random developer
            $game->developer()->associate($developers->random())->save();

            // Assign random genres (1-3)
            $game->genres()->sync($genres->random(rand(1, 3))->pluck('id')->toArray());

            // Assign random platforms (1-3)
            $game->platforms()->sync($platforms->random(rand(1, 3))->pluck('id')->toArray());
        });
    }
}
