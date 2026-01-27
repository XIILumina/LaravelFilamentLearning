<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Community;
use App\Models\Post;
use App\Models\Comment;
use App\Models\PostLike;
use App\Models\CommentLike;
use App\Models\CommunitySubscription;
use App\Models\Announcement;
use App\Models\Notification;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ComprehensiveSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Starting comprehensive seeding...');
        
        // Check if data already exists
        if (Community::count() > 20 || Post::count() > 100) {
            $this->command->warn('Database already has substantial data. Skipping to avoid duplicates.');
            $this->command->info('To reseed, please truncate relevant tables first.');
            return;
        }

        // Get or create a default game for communities
        $defaultGame = \App\Models\Game::first();
        if (!$defaultGame) {
            $this->command->warn('No games found in database. Communities will be created without game association.');
        }

        // Create 20 users with usernames
        $users = [];
        $usernames = [
            'gaming_legend', 'pixel_master', 'retro_gamer', 'pro_player', 'casual_joe',
            'speedrunner', 'achievement_hunter', 'indie_lover', 'esports_fan', 'strategy_king',
            'rpg_enthusiast', 'fps_sniper', 'puzzle_solver', 'adventure_seeker', 'sim_builder',
            'horror_fan', 'fighting_champ', 'racing_ace', 'card_master', 'mmo_hero'
        ];

        $names = [
            'Alex Johnson', 'Maria Garcia', 'James Smith', 'Sarah Williams', 'Michael Brown',
            'Emma Davis', 'David Miller', 'Olivia Wilson', 'Daniel Moore', 'Sophia Taylor',
            'Matthew Anderson', 'Isabella Thomas', 'Christopher Jackson', 'Mia White', 'Andrew Harris',
            'Charlotte Martin', 'Joshua Thompson', 'Amelia Garcia', 'Ryan Martinez', 'Harper Robinson'
        ];

        foreach ($usernames as $index => $username) {
            $users[] = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '.', $names[$index])) . '@example.com'],
                [
                    'name' => $names[$index],
                    'username' => $username,
                    'password' => Hash::make('password'),
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]
            );
        }

        // Create 25 diverse communities
        $communitiesData = [
            ['name' => 'Indie Game Developers', 'hashtag' => '#indiedev', 'description' => 'A community for indie game developers to share their projects and get feedback'],
            ['name' => 'Speedrunning Masters', 'hashtag' => '#speedrun', 'description' => 'Share your speedrun records and strategies'],
            ['name' => 'Retro Gaming Hub', 'hashtag' => '#retrogaming', 'description' => 'Celebrate classic games from the 80s, 90s, and early 2000s'],
            ['name' => 'RPG Enthusiasts', 'hashtag' => '#rpglovers', 'description' => 'Discuss your favorite role-playing games and characters'],
            ['name' => 'FPS Competitive', 'hashtag' => '#fpscomp', 'description' => 'First-person shooter competitive scene and tournaments'],
            ['name' => 'Horror Games Society', 'hashtag' => '#horrorgames', 'description' => 'For fans of scary and atmospheric games'],
            ['name' => 'Strategy Gamers', 'hashtag' => '#strategy', 'description' => 'Real-time and turn-based strategy game discussions'],
            ['name' => 'MMO Raiders', 'hashtag' => '#mmoraiders', 'description' => 'MMO guilds, raids, and endgame content'],
            ['name' => 'Fighting Game Community', 'hashtag' => '#fgc', 'description' => 'Fighting game tournaments and tech discussions'],
            ['name' => 'Simulation Builders', 'hashtag' => '#simbuilders', 'description' => 'City builders, farming sims, and life simulators'],
            ['name' => 'Esports News', 'hashtag' => '#esportsnews', 'description' => 'Latest esports news, matches, and player updates'],
            ['name' => 'Game Modding', 'hashtag' => '#gamemodding', 'description' => 'Share and discuss game mods and modding tools'],
            ['name' => 'VR Gaming', 'hashtag' => '#vrgaming', 'description' => 'Virtual reality games and experiences'],
            ['name' => 'Mobile Gaming', 'hashtag' => '#mobilegaming', 'description' => 'Best mobile games and tips'],
            ['name' => 'Puzzle Masters', 'hashtag' => '#puzzlemasters', 'description' => 'Brain teasers and puzzle game lovers'],
            ['name' => 'Survival Games', 'hashtag' => '#survivalgames', 'description' => 'Survival, crafting, and base-building games'],
            ['name' => 'Card Game Tactics', 'hashtag' => '#cardgames', 'description' => 'Digital card games and deck building strategies'],
            ['name' => 'Racing Enthusiasts', 'hashtag' => '#racinggames', 'description' => 'Racing simulations and arcade racers'],
            ['name' => 'Adventure Gaming', 'hashtag' => '#adventuregames', 'description' => 'Point-and-click and narrative adventures'],
            ['name' => 'Sandbox Creators', 'hashtag' => '#sandbox', 'description' => 'Creative sandbox games and builds'],
            ['name' => 'Roguelike Runners', 'hashtag' => '#roguelike', 'description' => 'Roguelike and roguelite game discussions'],
            ['name' => 'Game Collectors', 'hashtag' => '#gamecollectors', 'description' => 'Physical and digital game collecting'],
            ['name' => 'Streaming Tips', 'hashtag' => '#streamingtips', 'description' => 'Tips for game streamers and content creators'],
            ['name' => 'Couch Co-op', 'hashtag' => '#couchcoop', 'description' => 'Local multiplayer and party games'],
            ['name' => 'Achievement Hunters', 'hashtag' => '#achievements', 'description' => 'Trophy and achievement hunting guides'],
        ];

        $communities = [];
        foreach ($communitiesData as $communityData) {
            $communities[] = Community::create([
                'name' => $communityData['name'],
                'slug' => Str::slug($communityData['name']),
                'hashtag' => $communityData['hashtag'],
                'description' => $communityData['description'],
                'game_id' => $defaultGame?->id,
                'is_active' => true,
                'subscriber_count' => 0,
                'post_count' => 0,
            ]);
        }

        // Create subscriptions (random users subscribe to random communities)
        foreach ($users as $user) {
            $subscribedCommunities = fake()->randomElements($communities, rand(3, 8));
            foreach ($subscribedCommunities as $community) {
                CommunitySubscription::create([
                    'user_id' => $user->id,
                    'community_id' => $community->id,
                    'email_notifications' => fake()->boolean(70),
                    'push_notifications' => fake()->boolean(60),
                    'is_moderator' => fake()->boolean(5),
                    'subscribed_at' => now()->subDays(rand(1, 60)),
                ]);
                $community->increment('subscriber_count');
            }
        }

        // Create 150 posts
        $postTitles = [
            'Just finished this amazing game!', 'Best strategy for the final boss?', 'My record speedrun - Check it out!',
            'New game announcement - Thoughts?', 'Looking for co-op partners', 'This game changed my life',
            'Unpopular opinion about this franchise', 'Hidden gems you should play', 'Game of the Year predictions',
            'What are you playing this weekend?', 'Tutorial for beginners', 'Advanced tips and tricks',
        ];

        $posts = [];
        for ($i = 0; $i < 150; $i++) {
            $community = fake()->randomElement($communities);
            $author = fake()->randomElement($users);
            
            $post = Post::create([
                'title' => fake()->randomElement($postTitles) . ' ' . fake()->words(2, true),
                'content' => fake()->paragraphs(rand(2, 5), true) . ' What do you think? @' . fake()->randomElement($usernames),
                'user_id' => $author->id,
                'community_id' => $community->id,
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
            
            $posts[] = $post;
            $community->increment('post_count');
            $community->update(['last_post_at' => $post->created_at]);
        }

        // Create 500 comments
        for ($i = 0; $i < 500; $i++) {
            $post = fake()->randomElement($posts);
            Comment::create([
                'content' => fake()->sentence(rand(5, 20)),
                'user_id' => fake()->randomElement($users)->id,
                'post_id' => $post->id,
                'created_at' => $post->created_at->addMinutes(rand(1, 1440)),
            ]);
        }

        // Create likes
        foreach ($posts as $post) {
            $likers = fake()->randomElements($users, rand(2, 15));
            foreach ($likers as $liker) {
                PostLike::firstOrCreate(
                    ['user_id' => $liker->id, 'post_id' => $post->id],
                    ['is_like' => true]
                );
            }
        }

        $comments = Comment::all();
        foreach ($comments as $comment) {
            $likers = fake()->randomElements($users, rand(0, 8));
            foreach ($likers as $liker) {
                CommentLike::firstOrCreate(
                    ['user_id' => $liker->id, 'comment_id' => $comment->id],
                    ['is_like' => true]
                );
            }
        }

        // Create 50 messages
        for ($i = 0; $i < 50; $i++) {
            $sender = fake()->randomElement($users);
            $receiver = fake()->randomElement(array_filter($users, fn($u) => $u->id !== $sender->id));
            Message::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'message' => fake()->sentence(rand(5, 20)),
                'is_read' => fake()->boolean(60),
                'created_at' => now()->subDays(rand(0, 7)),
            ]);
        }

        // Create 10 announcements
        $admin = User::where('role', 'admin')->first() ?? $users[0];
        $announcementTitles = [
            'Welcome to our gaming community!', 'New features rolling out', 'Community guidelines update',
            'Weekend tournament', 'Server maintenance', 'Special event: Game giveaway!',
        ];

        foreach ($announcementTitles as $title) {
            Announcement::create([
                'title' => $title,
                'content' => fake()->paragraphs(2, true),
                'type' => fake()->randomElement(['general', 'update', 'event']),
                'is_active' => true,
                'published_at' => now()->subDays(rand(0, 7)),
                'created_by' => $admin->id,
            ]);
        }

        // Create 100 notifications
        for ($i = 0; $i < 100; $i++) {
            $user = fake()->randomElement($users);
            $fromUser = fake()->randomElement(array_filter($users, fn($u) => $u->id !== $user->id));
            Notification::create([
                'user_id' => $user->id,
                'type' => fake()->randomElement(['mention', 'new_post', 'message']),
                'message' => $fromUser->name . ' ' . fake()->randomElement(['mentioned you', 'liked your post', 'sent a message']),
                'link' => '/blog',
                'is_read' => fake()->boolean(40),
                'created_at' => now()->subHours(rand(1, 72)),
            ]);
        }

        $this->command->info('✅ Seeded successfully!');
    }
}
