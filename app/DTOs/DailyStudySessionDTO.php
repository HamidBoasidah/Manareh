<?php

namespace App\DTOs;

use App\Models\DailyStudySession;

class DailyStudySessionDTO extends BaseDTO
{
    public $id;
    public $circle_id;
    public $session_date_g;
    public $session_date_h;
    public $is_active;

    public function __construct($id, $circle_id = null, $session_date_g = null, $session_date_h = null)
    {
        $this->id = $id;
        $this->circle_id = $circle_id;
        $this->session_date_g = $session_date_g;
        $this->session_date_h = $session_date_h;
    }

    public static function fromModel(DailyStudySession $m): self
    {
        return new self(
            $m->id,
            $m->circle_id ?? null,
            $m->session_date_g ?? null,
            $m->session_date_h ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'circle_id' => $this->circle_id,
            'session_date_g' => $this->session_date_g,
            'session_date_h' => $this->session_date_h,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'circle_id' => $this->circle_id,
            'is_active' => $this->is_active ?? null,
        ];
    }
}
