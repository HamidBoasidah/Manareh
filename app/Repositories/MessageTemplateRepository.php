<?php

namespace App\Repositories;

use App\Models\MessageTemplate;
use App\Repositories\Eloquent\BaseRepository;

class MessageTemplateRepository extends BaseRepository
{
    protected array $defaultWith = [
        'mosque:id,name'
    ];

    public function __construct(MessageTemplate $model)
    {
        parent::__construct($model);
    }

    /**
     * 🔹 البحث عن قالب حسب الكود والمسجد واللغة.
     */
    public function findByCode(string $code, int $mosqueId, ?string $locale = 'ar')
    {
        return $this->model
            ->where('code', $code)
            ->where('mosque_id', $mosqueId)
            ->where('locale', $locale)
            ->where('is_active', true)
            ->first();
    }

    /**
     * 🔹 البحث عن جميع القوالب لمسجد معين.
     */
    public function findByMosque(int $mosqueId)
    {
        return $this->model
            ->where('mosque_id', $mosqueId)
            ->orderBy('code')
            ->get();
    }

    /**
     * 🔹 البحث عن القوالب المفعّلة فقط.
     */
    public function active()
    {
        return $this->model
            ->where('is_active', true)
            ->orderBy('id', 'desc')
            ->get();
    }
}
