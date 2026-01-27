<?php

namespace App\Services;

use App\Models\User;
use App\Models\Community;
use App\Models\Post;
use App\Models\Notification;
use Illuminate\Support\Str;

class NotificationService
{
    /**
     * Process content and send notifications for @username mentions and #community mentions
     */
    public function processContentMentions(string $content, Post $post, User $author): void
    {
        // Process @username mentions
        $this->processUserMentions($content, $post, $author);
        
        // Process #community mentions
        $this->processCommunityMentions($content, $post, $author);
    }

    /**
     * Process @username mentions in content
     */
    protected function processUserMentions(string $content, Post $post, User $author): void
    {
        // Find all @username mentions in the content
        preg_match_all('/@(\w+)/', $content, $matches);
        
        if (empty($matches[1])) {
            return;
        }

        $usernames = array_unique($matches[1]);
        
        foreach ($usernames as $username) {
            $mentionedUser = User::where('username', $username)->first();
            
            if ($mentionedUser && $mentionedUser->id !== $author->id) {
                Notification::createForUser(
                    $mentionedUser->id,
                    'mention',
                    "{$author->name} mentioned you in a post: \"{$post->title}\"",
                    route('communities.post', [$post->community, $post]),
                    [
                        'mentioned_by_user_id' => $author->id,
                        'post_id' => $post->id,
                        'community_id' => $post->community_id,
                    ]
                );
            }
        }
    }

    /**
     * Process #community mentions in content
     */
    protected function processCommunityMentions(string $content, Post $post, User $author): void
    {
        // Find all #community mentions (hashtags)
        preg_match_all('/#(\w+)/', $content, $matches);
        
        if (empty($matches[1])) {
            return;
        }

        $hashtags = array_unique($matches[1]);
        
        foreach ($hashtags as $hashtag) {
            // Try to find community by hashtag (with or without #)
            $community = Community::where('hashtag', '#' . $hashtag)
                ->orWhere('hashtag', $hashtag)
                ->first();
            
            if ($community && $community->id !== $post->community_id) {
                // Notify all subscribers of the mentioned community
                $this->notifyCommunitySubscribers($community, $post, $author);
            }
        }
    }

    /**
     * Notify all subscribers of a community about a mention
     */
    protected function notifyCommunitySubscribers(Community $community, Post $post, User $author): void
    {
        $subscribers = $community->subscribers()
            ->where('user_id', '!=', $author->id)
            ->get();

        foreach ($subscribers as $subscriber) {
            Notification::createForUser(
                $subscriber->id,
                'community_mention',
                "{$author->name} mentioned {$community->hashtag} in a post",
                route('communities.post', [$post->community, $post]),
                [
                    'mentioned_by_user_id' => $author->id,
                    'mentioned_community_id' => $community->id,
                    'post_id' => $post->id,
                    'source_community_id' => $post->community_id,
                ]
            );
        }
    }

    /**
     * Notify community subscribers about a new post
     */
    public function notifyNewPost(Post $post, User $author): void
    {
        if (!$post->community_id) {
            return;
        }

        $subscribers = $post->community->subscribers()
            ->where('user_id', '!=', $author->id)
            ->where('email_notifications', true) // Only notify users who opted in
            ->get();

        foreach ($subscribers as $subscriber) {
            Notification::createForUser(
                $subscriber->id,
                'new_post',
                "New post in {$post->community->hashtag}: \"{$post->title}\"",
                route('communities.post', [$post->community, $post]),
                [
                    'post_id' => $post->id,
                    'community_id' => $post->community_id,
                    'author_id' => $author->id,
                ]
            );
        }
    }

    /**
     * Send notifications for a new announcement
     */
    public function notifyAnnouncement(\App\Models\Announcement $announcement): void
    {
        // Get all active users
        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            Notification::createForUser(
                $user->id,
                'announcement',
                "New announcement: {$announcement->title}",
                route('inbox.index'),
                [
                    'announcement_id' => $announcement->id,
                ]
            );
        }
    }
}
