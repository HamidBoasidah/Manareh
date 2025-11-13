<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageTemplate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'code',
        'channel',
        'locale',
        'subject',
        'body',
        'description',
        'is_active',
        'is_core',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_core'   => 'boolean',
    ];

    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }

    public function renderSubject(array $variables = []): ?string
    {
        return $this->subject ? $this->replacePlaceholders($this->subject, $variables) : null;
    }

    public function renderBody(array $variables = []): ?string
    {
        return $this->body ? $this->replacePlaceholders($this->body, $variables) : null;
    }

    private function replacePlaceholders(string $content, array $variables): string
    {
        if (empty($variables)) {
            return $content;
        }

        $replacements = [];
        foreach ($variables as $key => $value) {
            $replacements['{' . $key . '}'] = is_scalar($value) || $value === null
                ? (string) ($value ?? '')
                : json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return strtr($content, $replacements);
    }
}
