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
}
