<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'photo',
        'user_id',
        'game_id',
        'community_id',
        'likes_count',
        'dislikes_count',
        'comments_count',
        'is_pinned'
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    public function userLike(User $user)
    {
        return $this->likes()->where('user_id', $user->id)->first();
    }

    public function isLikedBy(User $user): bool
    {
        $like = $this->userLike($user);
        return $like && $like->is_like;
    }

    public function isDislikedBy(User $user): bool
    {
        $like = $this->userLike($user);
        return $like && !$like->is_like;
    }
}
