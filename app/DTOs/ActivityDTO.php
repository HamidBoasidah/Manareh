<?php

namespace App\DTOs;

use App\Models\Activity;

class ActivityDTO extends BaseDTO
{
    public $id;
    public $mosque_id;
    public $title;
    public $description;
    public $activity_date_g;
    public $activity_date_h;
    public $place;
    public $is_active;

    public function __construct($id, $mosque_id = null, $title = null, $description = null, $activity_date_g = null, $activity_date_h = null, $place = null)
    {
        $this->id = $id;
        $this->mosque_id = $mosque_id;
        $this->title = $title;
        $this->description = $description;
        $this->activity_date_g = $activity_date_g;
        $this->activity_date_h = $activity_date_h;
        $this->place = $place;
    }

    public static function fromModel(Activity $m): self
    {
        return new self(
            $m->id,
            $m->mosque_id ?? null,
            $m->title ?? null,
            $m->description ?? null,
            $m->activity_date_g ?? null,
            $m->activity_date_h ?? null,
            $m->place ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'mosque_id' => $this->mosque_id,
            'title' => $this->title,
            'description' => $this->description,
            'activity_date_g' => $this->activity_date_g,
            'activity_date_h' => $this->activity_date_h,
            'place' => $this->place,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'is_active' => $this->is_active ?? null,
        ];
    }
}
