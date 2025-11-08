<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommunitySubscription extends Model
{
    protected $fillable = [
        'user_id',
        'community_id',
        'email_notifications',
        'push_notifications',
        'is_moderator',
        'subscribed_at',
    ];

    protected $casts = [
        'email_notifications' => 'boolean',
        'push_notifications' => 'boolean',
        'is_moderator' => 'boolean',
        'subscribed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscription) {
            if (empty($subscription->subscribed_at)) {
                $subscription->subscribed_at = now();
            }
        });

        static::created(function ($subscription) {
            $subscription->community->updateSubscriberCount();
        });

        static::deleted(function ($subscription) {
            $subscription->community->updateSubscriberCount();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }
}
