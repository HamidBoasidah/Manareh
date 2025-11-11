<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    /* -----------------------------------------------------------------
     | العلاقات (Relationships)
     |------------------------------------------------------------------ */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(MessageTemplate::class, 'template_id');
    }

    /* -----------------------------------------------------------------
     | Accessors / Virtual Attributes
     |------------------------------------------------------------------ */

    // ✅ هل تمت قراءة الإشعار؟
    protected function isRead(): Attribute
    {
        return Attribute::get(fn () => ! is_null($this->read_at));
    }

    // ✉️ ملخص أولي من الرسالة (للقائمة اليسرى في البريد)
    protected function shortBody(): Attribute
    {
        return Attribute::get(function () {
            $text = strip_tags($this->body ?? '');
            return mb_strimwidth($text, 0, 80, '...');
        });
    }

    // 💬 وصف نصي للحالة
    protected function statusLabel(): Attribute
    {
        return Attribute::get(function () {
            return match ($this->status) {
                'queued' => 'قيد الانتظار',
                'sent'   => 'تم الإرسال',
                'failed' => 'فشل الإرسال',
                default  => ucfirst($this->status),
            };
        });
    }

    /* -----------------------------------------------------------------
     | Scopes (لاستخدامها لاحقًا في الواجهة)
     |------------------------------------------------------------------ */

    public function scopeUnread($q)
    {
        return $q->whereNull('read_at');
    }

    public function scopeRead($q)
    {
        return $q->whereNotNull('read_at');
    }

    public function scopeInbox($q)
    {
        return $q->where('channel', 'inbox');
    }
}
