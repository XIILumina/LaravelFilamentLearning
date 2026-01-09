<?php

namespace Database\Seeders;

use App\Models\Community;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some games to create communities for
        $games = Game::take(5)->get();
        
        if ($games->isEmpty()) {
            $this->command->info('No games found. Please seed games first.');
            return;
        }

        $communityData = [
            [
                'name' => 'Team Fortress 2 Community',
                'description' => 'The official TF2 community for sharing strategies, funny moments, and updates about Team Fortress 2.',
                'hashtag' => '#TF2',
                'rules' => [
                    ['rule' => 'Be respectful to all community members'],
                    ['rule' => 'No cheating or exploit discussions'],
                    ['rule' => 'Keep posts relevant to Team Fortress 2'],
                    ['rule' => 'No spam or self-promotion without permission'],
                ]
            ],
            [
                'name' => 'Counter-Strike Global Community',
                'description' => 'Share your best plays, discuss strategies, and connect with other CS players worldwide.',
                'hashtag' => '#CSGO',
                'rules' => [
                    ['rule' => 'No toxic behavior or harassment'],
                    ['rule' => 'Share clips and screenshots freely'],
                    ['rule' => 'Help newcomers learn the game'],
                    ['rule' => 'Discuss tactics and team compositions'],
                ]
            ],
            [
                'name' => 'Minecraft Builders United',
                'description' => 'Show off your amazing builds, share redstone contraptions, and get inspiration from fellow crafters.',
                'hashtag' => '#MinecraftBuilds',
                'rules' => [
                    ['rule' => 'Share your build process and tips'],
                    ['rule' => 'Credit other builders when sharing their work'],
                    ['rule' => 'Help others with building techniques'],
                    ['rule' => 'Keep content family-friendly'],
                ]
            ],
            [
                'name' => 'Dark Souls Fellowship',
                'description' => 'A place for Souls veterans and newcomers to share experiences, tips, and jolly cooperation.',
                'hashtag' => '#DarkSouls',
                'rules' => [
                    ['rule' => 'No spoilers without proper warnings'],
                    ['rule' => 'Help fellow undead with boss strategies'],
                    ['rule' => 'Share your epic victories and defeats'],
                    ['rule' => 'Praise the sun! \\o/'],
                ]
            ],
            [
                'name' => 'League of Legends Rift',
                'description' => 'Discuss champions, share your best plays, and find teammates for ranked games.',
                'hashtag' => '#LeagueOfLegends',
                'rules' => [
                    ['rule' => 'No flame or toxic comments'],
                    ['rule' => 'Share educational content and guides'],
                    ['rule' => 'Discuss meta changes and patch notes'],
                    ['rule' => 'LFG posts are welcome in designated threads'],
                ]
            ],
        ];

        foreach ($communityData as $index => $data) {
            if (isset($games[$index])) {
                // Generate consistent placeholder images for each community based on index
                $placeholderId = $index + 1;
                Community::create([
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'hashtag' => $data['hashtag'],
                    'game_id' => $games[$index]->id,
                    'rules' => $data['rules'],
                    'is_active' => true,
                    'subscriber_count' => rand(50, 500),
                    'post_count' => rand(10, 100),
                    'last_post_at' => now()->subDays(rand(0, 30)),
                    'banner_image' => "https://picsum.photos/1200/300?random=$placeholderId",
                    'icon_image' => "https://picsum.photos/200/200?random=$placeholderId",
                ]);
            }
        }

        $this->command->info('Communities seeded successfully!');
    }
}
