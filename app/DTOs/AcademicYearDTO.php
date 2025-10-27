<?php

namespace App\DTOs;

use App\Models\AcademicYear;

class AcademicYearDTO extends BaseDTO
{
    public $id;
    public $mosque_id;
    public $name;
    public $start_date_g;
    public $end_date_g;
    public $start_date_h;
    public $end_date_h;
    public $is_active;
    public $mosque_name;

    public function __construct($id, $mosque_id, $name, $start_date_g, $end_date_g, $start_date_h, $end_date_h, $mosque_name = null, $is_active = null)
    {
        $this->id = $id;
        $this->mosque_id = $mosque_id;
        $this->name = $name;
        $this->start_date_g = $start_date_g;
        $this->end_date_g = $end_date_g;
        $this->start_date_h = $start_date_h;
        $this->end_date_h = $end_date_h;
        $this->mosque_name = $mosque_name;
        $this->is_active = $is_active;
    }

    public static function fromModel(AcademicYear $m): self
    {
        return new self(
            $m->id,
            $m->mosque_id,
            $m->name,
            $m->start_date_g,
            $m->end_date_g,
            $m->start_date_h,
            $m->end_date_h,
            $m->mosque?->name ?? null,
            $m->is_active ?? null,
            $m->start_date_g ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'mosque_id' => $this->mosque_id,
            'name' => $this->name,
            'start_date_g' => $this->start_date_g,
            'end_date_g' => $this->end_date_g,
            'start_date_h' => $this->start_date_h,
            'end_date_h' => $this->end_date_h,
            'mosque_name' => $this->mosque_name,
            'is_active' => $this->is_active,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mosque_name' => $this->mosque_name,
            'start_date_g' => $this->start_date_g,
            'end_date_g' => $this->end_date_g,
            'is_active' => $this->is_active ?? null,
        ];
    }
}
