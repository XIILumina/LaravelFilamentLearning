<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'game_id',
    ];

    /**
     * Get the user that owns the wishlist entry.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game that belongs to the wishlist entry.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }
}