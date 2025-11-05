<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Developer;

class DeveloperSeeder extends Seeder
{
    public function run(): void
    {
        $developers = [
            ['name' => 'Nintendo', 'website' => 'https://www.nintendo.com'],
            ['name' => 'Ubisoft', 'website' => 'https://www.ubisoft.com'],
            ['name' => 'Rockstar Games', 'website' => 'https://www.rockstargames.com'],
            ['name' => 'Valve', 'website' => 'https://www.valvesoftware.com'],
            ['name' => 'CD Projekt Red', 'website' => 'https://www.cdprojekt.com'],
        ];

        foreach ($developers as $developer) {
            Developer::create($developer);
        }
    }
}
