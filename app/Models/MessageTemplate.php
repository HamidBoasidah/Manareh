<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class MessageTemplate extends BaseModel
{
    use HasFactory;

    public const CHANNEL_IN_APP   = 'in_app';
    public const CHANNEL_SMS      = 'sms';
    public const CHANNEL_WHATSAPP = 'whatsapp';
    public const CHANNEL_EMAIL    = 'email';

    public const CHANNELS = [
        self::CHANNEL_IN_APP,
        self::CHANNEL_SMS,
        self::CHANNEL_WHATSAPP,
        self::CHANNEL_EMAIL,
    ];

    public const VARIABLE_TYPES = [
        'string',
        'text',
        'number',
        'date',
        'time',
        'datetime',
    ];

    protected $fillable = [
        'mosque_id',
        'code',
        'name',
        'channel',
        'locale',
        'subject',
        'description',
        'body',
        'variables',
        'sample_payload',
        'extras',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'variables' => 'array',
        'sample_payload' => 'array',
        'extras' => 'array',
        'is_active' => 'boolean',
    ];

    public static function availableLocales(): array
    {
        $locales = config('app.available_locales', [config('app.locale')]);

        return array_values(array_unique(array_filter($locales)));
    }

    public static function normalizeVariableKey(string $key): string
    {
        $clean = trim($key);
    $clean = preg_replace('/[^A-Za-z0-9_.\-]/', '_', $clean) ?? $clean;

        return Str::of($clean)->lower()->replace('-', '_')->toString();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
