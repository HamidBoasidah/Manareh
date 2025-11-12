<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

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
    ];

    public function template()
    {
        return $this->belongsTo(MessageTemplate::class, 'template_id');
    }

    // هل الإشعار مقروء؟
    public function getIsReadAttribute(): bool
    {
        return ! is_null($this->read_at);
    }

    // نص مختصر للقائمة الجانبية
    public function getShortBodyAttribute(): string
    {
        $text = strip_tags((string) $this->body);
        return mb_strlen($text) > 80
            ? mb_substr($text, 0, 80) . '...'
            : $text;
    }

    // صيغة الوقت (تستفيد منها بالـ DTO إن حبيت)
    public function getCreatedAtHumanAttribute(): string
    {
        return $this->created_at
            ? $this->created_at->diffForHumans()
            : '';
    }
}
