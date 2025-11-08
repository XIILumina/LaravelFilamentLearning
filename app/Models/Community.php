<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Community extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'banner_image',
        'icon_image',
        'game_id',
        'hashtag',
        'subscriber_count',
        'post_count',
        'is_active',
        'rules',
        'moderators',
        'last_post_at',
    ];

    protected $casts = [
        'rules' => 'array',
        'moderators' => 'array',
        'is_active' => 'boolean',
        'last_post_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($community) {
            if (empty($community->slug)) {
                $community->slug = Str::slug($community->name);
            }
            if (empty($community->hashtag)) {
                $community->hashtag = '#' . Str::slug($community->name, '');
            }
        });

        static::updating(function ($community) {
            if ($community->isDirty('name') && empty($community->slug)) {
                $community->slug = Str::slug($community->name);
            }
        });
    }

    // Relationships
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function subscribers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_subscriptions')
            ->withPivot(['email_notifications', 'push_notifications', 'is_moderator', 'subscribed_at'])
            ->withTimestamps();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(CommunitySubscription::class);
    }

    public function moderators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'community_subscriptions')
            ->wherePivot('is_moderator', true)
            ->withPivot(['email_notifications', 'push_notifications', 'subscribed_at'])
            ->withTimestamps();
    }

    // Helper methods
    public function isSubscribedBy(User $user): bool
    {
        return $this->subscribers()->where('user_id', $user->id)->exists();
    }

    public function isModeratedBy(User $user): bool
    {
        return $this->moderators()->where('user_id', $user->id)->exists();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function updateSubscriberCount(): void
    {
        $this->update([
            'subscriber_count' => $this->subscribers()->count()
        ]);
    }

    public function updatePostCount(): void
    {
        $this->update([
            'post_count' => $this->posts()->count(),
            'last_post_at' => $this->posts()->latest()->first()?->created_at
        ]);
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name . ' (' . $this->hashtag . ')';
    }

    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner_image ? asset('storage/' . $this->banner_image) : null;
    }

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon_image ? asset('storage/' . $this->icon_image) : null;
    }
}
