<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
    public function wishlistGames()
    {
        return $this->belongsToMany(Game::class, 'wishlists');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function postLikes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function commentLikes()
    {
        return $this->hasMany(CommentLike::class);
    }

    public function subscribedCommunities()
    {
        return $this->belongsToMany(Community::class, 'community_subscriptions')
            ->withPivot(['email_notifications', 'push_notifications', 'is_moderator', 'subscribed_at'])
            ->withTimestamps();
    }

    public function moderatedCommunities()
    {
        return $this->belongsToMany(Community::class, 'community_subscriptions')
            ->wherePivot('is_moderator', true)
            ->withPivot(['email_notifications', 'push_notifications', 'subscribed_at'])
            ->withTimestamps();
    }

    public function communitySubscriptions()
    {
        return $this->hasMany(CommunitySubscription::class);
    }

    public function isSubscribedTo(Community $community): bool
    {
        return $this->subscribedCommunities()->where('community_id', $community->id)->exists();
    }

    public function isModeratorOf(Community $community): bool
    {
        return $this->moderatedCommunities()->where('community_id', $community->id)->exists();
    }
}