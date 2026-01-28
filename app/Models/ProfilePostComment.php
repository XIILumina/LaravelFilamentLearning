<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfilePostComment extends Model
{
    protected $fillable = [
        'profile_post_id',
        'user_id',
        'content',
    ];

    public function profilePost(): BelongsTo
    {
        return $this->belongsTo(ProfilePost::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
