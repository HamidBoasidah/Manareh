<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Notification extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'recipient_type',
        'recipient_id',
        'channel',
        'template_id',
        'subject',
        'body',
        'payload',
        'status',
        'sent_at',
        'read_at',
        'error',
        'is_active',
    ];

    protected $casts = [
        'payload' => 'array',
        'sent_at' => 'datetime',
        'read_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(MessageTemplate::class, 'template_id');
    }

    public function recipient(): MorphTo
    {
        return $this->morphTo();
    }

    public function markAsRead(): void
    {
        if (! $this->read_at) {
            $this->forceFill(['read_at' => now()])->save();
        }
    }

    public function markAsUnread(): void
    {
        if ($this->read_at) {
            $this->forceFill(['read_at' => null])->save();
        }
    }

    /**
     * Scope notifications visible to a given user.
     * Supports notifications targeted via `user_id` or polymorphic `recipient_type` = 'user' / recipient_id.
     * Extend this if you support role/circle broadcasts.
     */
    public function scopeForUser($query, \App\Models\User $user)
    {
        return $query->where(function ($q) use ($user) {
            $q->where('user_id', $user->getKey())
                ->orWhere(function ($q2) use ($user) {
                    $q2->where('recipient_type', 'user')
                        ->where('recipient_id', $user->getKey());
                });
        });
    }

    /**
     * Return true if the given user is the intended recipient of this notification (or a super-admin).
     */
    public function isRecipient(\App\Models\User $user): bool
    {
        if ($this->user_id && (int) $this->user_id === (int) $user->getKey()) {
            return true;
        }

        if ($this->recipient_type === 'user' && (int) $this->recipient_id === (int) $user->getKey()) {
            return true;
        }

        // Broadcast / global notifications: treat as visible to all users
        if (is_null($this->recipient_type) || $this->recipient_type === 'all') {
            return true;
        }

        return false;
    }
}
