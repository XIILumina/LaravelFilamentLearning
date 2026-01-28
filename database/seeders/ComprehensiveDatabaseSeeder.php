<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Developer;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Game;
use App\Models\Community;
use App\Models\CommunitySubscription;
use App\Models\Post;
use App\Models\Comment;
use App\Models\PostLike;
use App\Models\CommentLike;
use App\Models\Wishlist;
use App\Models\Message;
use App\Models\Notification;
use App\Models\Announcement;
use App\Models\Contact;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\GameAttribute;
use App\Models\Friendship;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ComprehensiveDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.admin'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('admin@admin.admin'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        // Create Test User
        $testUser = User::firstOrCreate(
            ['email' => 'test@test.test'],
            [
                'name' => 'Test User',
                'username' => 'test',
                'password' => Hash::make('test@test.test'),
                'email_verified_at' => now(),
                'role' => 'user',
            ]
        );

        // Create additional regular users
        $users = User::factory(15)->create([
            'role' => 'user',
        ]);
        $users->push($testUser);

        // Create Developers
        $developers = collect([
            ['name' => 'Rockstar Games', 'website' => 'https://www.rockstargames.com'],
            ['name' => 'CD Projekt Red', 'website' => 'https://www.cdprojektred.com'],
            ['name' => 'Valve Corporation', 'website' => 'https://www.valvesoftware.com'],
            ['name' => 'Nintendo EPD', 'website' => 'https://www.nintendo.com'],
            ['name' => 'FromSoftware', 'website' => 'https://www.fromsoftware.jp'],
            ['name' => 'Bethesda Game Studios', 'website' => 'https://bethesdagamestudios.com'],
            ['name' => 'Naughty Dog', 'website' => 'https://www.naughtydog.com'],
            ['name' => 'Mojang Studios', 'website' => 'https://www.minecraft.net'],
        ])->map(fn($data) => Developer::firstOrCreate(['name' => $data['name']], $data));

        // Create Genres
        $genres = collect([
            ['name' => 'Action'],
            ['name' => 'RPG'],
            ['name' => 'Adventure'],
            ['name' => 'Strategy'],
            ['name' => 'Simulation'],
            ['name' => 'Sports'],
            ['name' => 'Racing'],
            ['name' => 'Horror'],
            ['name' => 'Puzzle'],
            ['name' => 'Shooter'],
        ])->map(fn($data) => Genre::firstOrCreate(['name' => $data['name']], $data));

        // Create Platforms
        $platforms = collect([
            ['name' => 'PC'],
            ['name' => 'PlayStation 5'],
            ['name' => 'Xbox Series X/S'],
            ['name' => 'Nintendo Switch'],
            ['name' => 'PlayStation 4'],
            ['name' => 'Xbox One'],
        ])->map(fn($data) => Platform::firstOrCreate(['name' => $data['name']], $data));

        // Create Games
        $gamesData = [
            [
                'title' => 'The Witcher 3: Wild Hunt',
                'description' => 'An epic open-world RPG with a deep story and stunning visuals',
                'publisher' => 'CD Projekt',
                'release_date' => '2015-05-19',
                'rating' => 9.5,
                'image_url' => '',
                'developer' => 'CD Projekt Red',
                'genres' => ['RPG', 'Action', 'Adventure'],
                'platforms' => ['PC', 'PlayStation 4', 'Xbox One', 'Nintendo Switch'],
            ],
            [
                'title' => 'Elden Ring',
                'description' => 'A challenging action RPG in a vast open world',
                'publisher' => 'Bandai Namco',
                'release_date' => '2022-02-25',
                'rating' => 9.3,
                'image_url' => '',
                'developer' => 'FromSoftware',
                'genres' => ['Action', 'RPG'],
                'platforms' => ['PC', 'PlayStation 5', 'Xbox Series X/S', 'PlayStation 4', 'Xbox One'],
            ],
            [
                'title' => 'Red Dead Redemption 2',
                'description' => 'An epic tale of life in America\'s unforgiving heartland',
                'publisher' => 'Rockstar Games',
                'release_date' => '2018-10-26',
                'rating' => 9.7,
                'image_url' => '',
                'developer' => 'Rockstar Games',
                'genres' => ['Action', 'Adventure'],
                'platforms' => ['PC', 'PlayStation 4', 'Xbox One'],
            ],
            [
                'title' => 'Minecraft',
                'description' => 'A sandbox game where you can build anything you can imagine',
                'publisher' => 'Mojang Studios',
                'release_date' => '2011-11-18',
                'rating' => 9.0,
                'image_url' => '',
                'developer' => 'Mojang Studios',
                'genres' => ['Simulation', 'Adventure'],
                'platforms' => ['PC', 'PlayStation 5', 'Xbox Series X/S', 'Nintendo Switch', 'PlayStation 4', 'Xbox One'],
            ],
            [
                'title' => 'The Last of Us Part II',
                'description' => 'An emotional journey through a post-apocalyptic world',
                'publisher' => 'Sony Interactive',
                'release_date' => '2020-06-19',
                'rating' => 9.4,
                'image_url' => '',
                'developer' => 'Naughty Dog',
                'genres' => ['Action', 'Adventure', 'Horror'],
                'platforms' => ['PlayStation 5', 'PlayStation 4'],
            ],
            [
                'title' => 'The Elder Scrolls V: Skyrim',
                'description' => 'An open-world RPG set in the land of dragons',
                'publisher' => 'Bethesda Softworks',
                'release_date' => '2011-11-11',
                'rating' => 9.2,
                'image_url' => '',
                'developer' => 'Bethesda Game Studios',
                'genres' => ['RPG', 'Action', 'Adventure'],
                'platforms' => ['PC', 'PlayStation 5', 'Xbox Series X/S', 'Nintendo Switch', 'PlayStation 4', 'Xbox One'],
            ],
            [
                'title' => 'Portal 2',
                'description' => 'A mind-bending puzzle game with humor and heart',
                'publisher' => 'Valve',
                'release_date' => '2011-04-19',
                'rating' => 9.5,
                'image_url' => '',
                'developer' => 'Valve Corporation',
                'genres' => ['Puzzle', 'Adventure'],
                'platforms' => ['PC', 'PlayStation 4', 'Xbox One'],
            ],
        ];

        $games = collect($gamesData)->map(function ($gameData) use ($developers, $genres, $platforms) {
            $developer = $developers->firstWhere('name', $gameData['developer']);
            
            $game = Game::firstOrCreate(
                ['title' => $gameData['title']],
                [
                    'description' => $gameData['description'],
                    'publisher' => $gameData['publisher'],
                    'release_date' => $gameData['release_date'],
                    'rating' => $gameData['rating'],
                    'image_url' => $gameData['image_url'],
                    'developer_id' => $developer->id,
                ]
            );

            // Attach genres
            $gameGenres = $genres->whereIn('name', $gameData['genres']);
            $game->genres()->syncWithoutDetaching($gameGenres->pluck('id'));

            // Attach platforms
            $gamePlatforms = $platforms->whereIn('name', $gameData['platforms']);
            $game->platforms()->syncWithoutDetaching($gamePlatforms->pluck('id'));

            return $game;
        });

        // Create Attributes for PIM System
        $attributes = collect([
            ['name' => 'ESRB Rating', 'slug' => 'esrb-rating', 'input_type' => 'select', 'field_type' => 'text', 'description' => 'Entertainment Software Rating Board rating'],
            ['name' => 'Multiplayer', 'slug' => 'multiplayer', 'input_type' => 'checkbox', 'field_type' => 'boolean', 'description' => 'Supports multiplayer gameplay'],
            ['name' => 'Co-op', 'slug' => 'co-op', 'input_type' => 'checkbox', 'field_type' => 'boolean', 'description' => 'Supports cooperative gameplay'],
            ['name' => 'File Size', 'slug' => 'file-size', 'input_type' => 'text', 'field_type' => 'text', 'description' => 'Download/installation size'],
            ['name' => 'Languages', 'slug' => 'languages', 'input_type' => 'multiselect', 'field_type' => 'text', 'description' => 'Supported languages'],
            ['name' => 'VR Support', 'slug' => 'vr-support', 'input_type' => 'checkbox', 'field_type' => 'boolean', 'description' => 'Virtual Reality support'],
        ])->map(fn($data) => Attribute::firstOrCreate(['slug' => $data['slug']], $data));

        // Create Attribute Values for select-type attributes
        $esrbRating = $attributes->firstWhere('slug', 'esrb-rating');
        $esrbValues = ['E - Everyone', 'E10+ - Everyone 10+', 'T - Teen', 'M - Mature', 'AO - Adults Only'];
        foreach ($esrbValues as $value) {
            AttributeValue::firstOrCreate([
                'attribute_id' => $esrbRating->id,
                'value' => $value,
            ]);
        }

        // Assign some attributes to games
        foreach ($games->take(5) as $game) {
            GameAttribute::firstOrCreate([
                'game_id' => $game->id,
                'attribute_id' => $esrbRating->id,
                'value' => $esrbValues[array_rand($esrbValues)],
            ]);

            $multiplayer = $attributes->firstWhere('slug', 'multiplayer');
            GameAttribute::firstOrCreate([
                'game_id' => $game->id,
                'attribute_id' => $multiplayer->id,
                'value' => (string) (rand(0, 1) === 1),
            ]);
        }

        // Create Communities
        $communitiesData = [
            ['name' => 'RPG Enthusiasts', 'slug' => 'rpg-enthusiasts', 'description' => 'For lovers of role-playing games', 'hashtag' => '#rpgenthusiasts'],
            ['name' => 'Indie Games', 'slug' => 'indie-games', 'description' => 'Discover and discuss indie titles', 'hashtag' => '#indiegames'],
            ['name' => 'Speedrunning', 'slug' => 'speedrunning', 'description' => 'Breaking records one frame at a time', 'hashtag' => '#speedrunning'],
            ['name' => 'Horror Gaming', 'slug' => 'horror-gaming', 'description' => 'For those who love a good scare', 'hashtag' => '#horrorgaming'],
            ['name' => 'Racing Enthusiasts', 'slug' => 'racing-enthusiasts', 'description' => 'All about racing games', 'hashtag' => '#racinggames'],
            ['name' => 'Strategy Masters', 'slug' => 'strategy-masters', 'description' => 'Tactical and strategic gameplay', 'hashtag' => '#strategygames'],
        ];

        $communities = collect($communitiesData)->map(function ($data) use ($games) {
            return Community::firstOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, [
                    'game_id' => $games->random()->id,
                    'subscriber_count' => 0,
                ])
            );
        });

        // Subscribe users to communities
        foreach ($users as $user) {
            $userCommunities = $communities->random(rand(1, 4));
            foreach ($userCommunities as $community) {
                CommunitySubscription::firstOrCreate([
                    'user_id' => $user->id,
                    'community_id' => $community->id,
                ], [
                    'email_notifications' => rand(0, 1),
                    'push_notifications' => rand(0, 1),
                    'is_moderator' => false,
                    'subscribed_at' => now(),
                ]);
                $community->increment('subscriber_count');
            }
        }

        // Create Posts
        $posts = collect();
        foreach ($communities as $community) {
            for ($i = 0; $i < rand(3, 8); $i++) {
                $post = Post::create([
                    'user_id' => $users->random()->id,
                    'community_id' => $community->id,
                    'title' => fake()->sentence(),
                    'content' => fake()->paragraphs(rand(2, 5), true),
                    'is_pinned' => rand(0, 10) > 8,
                    'created_at' => now()->subDays(rand(0, 30)),
                ]);
                $posts->push($post);
            }
        }

        // Create Comments
        foreach ($posts as $post) {
            for ($i = 0; $i < rand(0, 10); $i++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'post_id' => $post->id,
                    'content' => fake()->paragraph(),
                    'created_at' => $post->created_at->addMinutes(rand(10, 1000)),
                ]);
            }
        }

        // Create Post Likes
        foreach ($posts as $post) {
            $likers = $users->random(rand(0, 10));
            foreach ($likers as $user) {
                PostLike::firstOrCreate([
                    'user_id' => $user->id,
                    'post_id' => $post->id,
                ], [
                    'is_like' => true,
                ]);
            }
        }

        // Create Comment Likes
        $comments = Comment::all();
        foreach ($comments as $comment) {
            $likers = $users->random(rand(0, 5));
            foreach ($likers as $user) {
                CommentLike::firstOrCreate([
                    'user_id' => $user->id,
                    'comment_id' => $comment->id,
                ], [
                    'is_like' => true,
                ]);
            }
        }

        // Create Wishlists
        foreach ($users->take(10) as $user) {
            $wishlistGames = $games->random(rand(1, 5));
            foreach ($wishlistGames as $game) {
                Wishlist::firstOrCreate([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                ]);
            }
        }

        // Create Messages
        for ($i = 0; $i < 30; $i++) {
            $sender = $users->random();
            $receiver = $users->where('id', '!=', $sender->id)->random();
            
            Message::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'message' => fake()->sentence(),
                'is_read' => rand(0, 1),
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
        }

        // Create Notifications
        foreach ($users->take(10) as $user) {
            for ($i = 0; $i < rand(2, 8); $i++) {
                Notification::create([
                    'user_id' => $user->id,
                    'type' => ['mention', 'message', 'comment', 'like'][array_rand(['mention', 'message', 'comment', 'like'])],
                    'message' => fake()->sentence(),
                    'link' => route('dashboard'),
                    'is_read' => rand(0, 1),
                    'created_at' => now()->subDays(rand(0, 15)),
                ]);
            }
        }

        // Create Announcements
        Announcement::create([
            'title' => 'Welcome to GameHub!',
            'content' => 'We\'re excited to have you here. Explore games, join communities, and connect with fellow gamers!',
            'type' => 'announcement',
            'is_active' => true,
            'published_at' => now()->subDays(7),
        ]);

        Announcement::create([
            'title' => 'Weekly Game Sale',
            'content' => 'Check out our featured games this week with amazing discounts!',
            'type' => 'event',
            'is_active' => true,
            'published_at' => now()->subDays(2),
        ]);

        Announcement::create([
            'title' => 'Scheduled Maintenance',
            'content' => 'The site will undergo maintenance this weekend. Expect brief downtime.',
            'type' => 'maintenance',
            'is_active' => true,
            'published_at' => now()->subDay(),
        ]);

        // Create Contact Messages
        for ($i = 0; $i < 5; $i++) {
            Contact::create([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'subject' => fake()->sentence(),
                'message' => fake()->paragraphs(3, true),
                'status' => ['pending', 'in_progress', 'resolved'][array_rand(['pending', 'in_progress', 'resolved'])],
            ]);
        }

        // Create Friendships
        foreach ($users->take(8) as $user) {
            $potentialFriends = $users->where('id', '!=', $user->id)->random(rand(2, 5));
            foreach ($potentialFriends as $friend) {
                // Avoid duplicate friendships
                $exists = Friendship::where(function ($query) use ($user, $friend) {
                    $query->where('user_id', $user->id)->where('friend_id', $friend->id);
                })->orWhere(function ($query) use ($user, $friend) {
                    $query->where('user_id', $friend->id)->where('friend_id', $user->id);
                })->exists();

                if (!$exists) {
                    Friendship::create([
                        'user_id' => $user->id,
                        'friend_id' => $friend->id,
                        'status' => rand(0, 10) > 3 ? 'accepted' : 'pending',
                    ]);
                }
            }
        }

        $this->command->info('Database seeded successfully with comprehensive data!');
        $this->command->info('Admin: admin@admin.admin / admin@admin.admin');
        $this->command->info('Test User: test@test.test / test@test.test');
    }
}
