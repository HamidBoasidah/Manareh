<?php

namespace App\DTOs;

use App\Models\Term;

class TermDTO extends BaseDTO
{
    public $id;
    public $academic_year_id;
    public $academic_year_name;
    public $name;
    public $start_date_g;
    public $end_date_g;
    public $start_date_h;
    public $end_date_h;
    public $is_active;

    public function __construct(
        $id,
        $academic_year_id = null,
        $academic_year_name = null,
        $name = null,
        $start_date_g = null,
        $end_date_g = null,
        $start_date_h = null,
        $end_date_h = null,
        $is_active = null
    ) {
        $this->id = $id;
        $this->academic_year_id = $academic_year_id;
        $this->academic_year_name = $academic_year_name;
        $this->name = $name;
        $this->start_date_g = $start_date_g;
        $this->end_date_g = $end_date_g;
        $this->start_date_h = $start_date_h;
        $this->end_date_h = $end_date_h;
        $this->is_active = $is_active;
    }

    public static function fromModel(Term $term): self
    {
        return new self(
            $term->id,
            $term->academic_year_id ?? null,
            $term->academicYear?->name ?? null,
            $term->name ?? null,
            $term->start_date_g ?? null,
            $term->end_date_g ?? null,
            $term->start_date_h ?? null,
            $term->end_date_h ?? null,
            $term->is_active ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'academic_year_id' => $this->academic_year_id,
            'academic_year_name' => $this->academic_year_name,
            'name' => $this->name,
            'start_date_g' => $this->start_date_g,
            'end_date_g' => $this->end_date_g,
            'start_date_h' => $this->start_date_h,
            'end_date_h' => $this->end_date_h,
            'is_active' => $this->is_active,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'academic_year_name' => $this->academic_year_name,
            'start_date_g' => $this->start_date_g,
            'end_date_g' => $this->end_date_g,
            'is_active' => $this->is_active,
        ];
    }
}
