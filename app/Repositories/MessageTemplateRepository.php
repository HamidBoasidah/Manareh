<?php

namespace App\Repositories;

use App\Models\MessageTemplate;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class MessageTemplateRepository extends BaseRepository
{
    public function __construct(MessageTemplate $model)
    {
        parent::__construct($model);
    }

    public function findByCode(string $code, ?int $mosqueId = null, ?string $locale = null, string $channel = 'inbox'): ?MessageTemplate
    {
        $query = $this->query()
            ->where('code', $code)
            ->where('channel', $channel)
            ->where('is_active', true);

        if ($locale) {
            $query->where('locale', $locale);
        }

        if ($mosqueId === null) {
            $query->whereNull('mosque_id');
        } else {
            $query->where('mosque_id', $mosqueId);
        }

        return $query->first();
    }

    public function scopeForMosque(Builder $query, ?int $mosqueId): Builder
    {
        if ($mosqueId === null) {
            return $query->whereNull('mosque_id');
        }

        return $query->where('mosque_id', $mosqueId);
    }
}
