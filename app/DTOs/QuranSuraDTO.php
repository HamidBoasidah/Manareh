<?php

namespace App\DTOs;

use App\Models\QuranSura;

class QuranSuraDTO extends BaseDTO
{
    public $id;
    public $name_ar;
    public $name_en;
    public $ayah_count;
    public $is_active;
    public function __construct($id, $name_ar, $name_en, $ayah_count, $is_active)
    {
        $this->id = $id;
        $this->name_ar = $name_ar;
        $this->name_en = $name_en;
        $this->ayah_count = $ayah_count;
        $this->is_active = $is_active;
    }

    public static function fromModel(QuranSura $m): self
    {
        return new self(
            $m->id,
            $m->name_ar,
            $m->name_en,
            $m->ayah_count,
            $m->is_active
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'ayah_count' => $this->ayah_count,
            'is_active' => $this->is_active,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'ayah_count' => $this->ayah_count,
            'is_active' => $this->is_active,
        ];
    }
}
