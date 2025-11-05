<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Platform;

class PlatformSeeder extends Seeder
{
    public function run(): void
    {
        $platforms = ['PC', 'PlayStation 5', 'Xbox Series X', 'Nintendo Switch', 'Mobile'];

        foreach ($platforms as $name) {
            Platform::create(['name' => $name]);
        }
    }
}
