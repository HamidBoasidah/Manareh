<?php

namespace App\DTOs;

use App\Models\DailyStudySession;

class DailyStudySessionDTO extends BaseDTO
{
    public $id;
    public $circle_id;
    public $circle_name;
    public $session_date_g;
    public $session_date_h;
    public $is_active;

    public function __construct(
        $id,
        $circle_id = null,
        $circle_name = null,
        $session_date_g = null,
        $session_date_h = null,
        $is_active = null
    )
    {
        $this->id = $id;
        $this->circle_id = $circle_id;
        $this->circle_name = $circle_name;
        $this->session_date_g = $session_date_g;
        $this->session_date_h = $session_date_h;
        $this->is_active = $is_active;
    }

    public static function fromModel(DailyStudySession $m): self
    {
        $circle = $m->circle;

        return new self(
            $m->id,
            $m->circle_id ?? null,
            $circle?->name,
            optional($m->session_date_g)->format('Y-m-d'),
            $m->session_date_h ?? null,
            $m->is_active
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'circle_id' => $this->circle_id,
            'circle_name' => $this->circle_name,
            'session_date_g' => $this->session_date_g,
            'session_date_h' => $this->session_date_h,
            'is_active' => $this->is_active,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'circle_id' => $this->circle_id,
            'circle_name' => $this->circle_name,
            'session_date_g' => $this->session_date_g,
            'session_date_h' => $this->session_date_h,
            'is_active' => $this->is_active ?? null,
        ];
    }
}
