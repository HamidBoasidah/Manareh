<?php

namespace App\DTOs;

use App\Models\ExamType;

class ExamTypeDTO extends BaseDTO
{
    public $id;
    public $mosque_id;
    public $name;
    public $is_active;
    public $mosque;
    public $mosque_name_ar;
    public $mosque_name_en;

    public function __construct($id, $mosque_id = null, $name = null, $is_active = null)
    {
        $this->id = $id;
        $this->mosque_id = $mosque_id;
        $this->name = $name;
        $this->is_active = $is_active;
    }

    public static function fromModel(ExamType $m): self
    {
        $dto = new self(
            $m->id,
            $m->mosque_id ?? null,
            $m->name ?? null,
            (bool) $m->is_active,
        );

        if ($m->relationLoaded('mosque') && $m->mosque) {
            $dto->mosque = [
                'id' => $m->mosque->id,
                'name' => $m->mosque->name,
            ];
            $dto->mosque_name_ar = $m->mosque->name_ar ?? $m->mosque->name;
            $dto->mosque_name_en = $m->mosque->name_en ?? $m->mosque->name;
        } else {
            $dto->mosque = null;
            $dto->mosque_name_ar = null;
            $dto->mosque_name_en = null;
        }

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'mosque_id' => $this->mosque_id,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'mosque' => $this->mosque,
            'mosque_name_ar' => $this->mosque_name_ar,
            'mosque_name_en' => $this->mosque_name_en,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mosque_id' => $this->mosque_id,
            'is_active' => $this->is_active,
            'mosque' => $this->mosque,
            'mosque_name_ar' => $this->mosque_name_ar,
            'mosque_name_en' => $this->mosque_name_en,
        ];
    }
}
