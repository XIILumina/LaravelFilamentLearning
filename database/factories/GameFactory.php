<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Game;

/**
 * @extends Factory<Game>
 */
class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(3),
            'description' => $this->faker->paragraph,
            'release_date' => $this->faker->date(),
            'publisher' => $this->faker->company,
            'rating' => $this->faker->randomFloat(1, 0, 10),
            'image_url' => 'games/' . $this->faker->numberBetween(1, 10) . '.png', // placeholder
            'featured' => $this->faker->boolean(20), // 20% chance featured
        ];
    }
}
