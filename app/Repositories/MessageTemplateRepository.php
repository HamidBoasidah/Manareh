<?php

namespace App\Repositories;

use App\Models\MessageTemplate;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class MessageTemplateRepository extends BaseRepository
{
    protected array $defaultWith = [
        'mosque:id,name',
        'creator:id,name',
        'updater:id,name',
    ];

    public function __construct(MessageTemplate $model)
    {
        parent::__construct($model);
    }

    public function paginateWithFilters(array $filters = [], int $perPage = 15)
    {
        $query = $this->builder();

        if (!empty($filters['mosque_id'])) {
            $query->where('mosque_id', $filters['mosque_id']);
        }

        if (!empty($filters['channel'])) {
            $query->where('channel', $filters['channel']);
        }

        if (!empty($filters['locale'])) {
            $query->where('locale', $filters['locale']);
        }

        if (array_key_exists('is_active', $filters) && $filters['is_active'] !== null && $filters['is_active'] !== '') {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false);
        }

        if (!empty($filters['search'])) {
            $search = trim((string) $filters['search']);

            $query->where(function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

    $allowedSorts = ['code', 'name', 'channel', 'locale', 'updated_at', 'created_at'];
    $sort = in_array($filters['sort'] ?? '', $allowedSorts, true) ? $filters['sort'] : 'updated_at';
    $direction = strtolower($filters['direction'] ?? 'desc') === 'asc' ? 'asc' : 'desc';

    $query->orderBy($sort, $direction);

        return $query->paginate($perPage)->withQueryString();
    }
}
