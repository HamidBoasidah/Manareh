<?php

namespace App\DTOs;

use App\Models\ExamItem;

class ExamItemDTO extends BaseDTO
{
    public $id;
    public $exam_id;
    public $item_key;
    public $max_points;
    public $score_points;
    public $is_active;
    public $created_at;

    public function __construct(
        $id,
        $exam_id = null,
        $item_key = null,
        $max_points = null,
        $score_points = null,
        $is_active = null,
        $created_at = null
    ) {
        $this->id = $id;
        $this->exam_id = $exam_id;
        $this->item_key = $item_key;
        $this->max_points = $max_points;
        $this->score_points = $score_points;
        $this->is_active = $is_active;
        $this->created_at = $created_at;
    }

    public static function fromModel(ExamItem $m): self
    {
        $format = function ($val) {
            if ($val instanceof \DateTimeInterface) {
                return $val->format('Y-m-d H:i:s');
            }
            return $val;
        };

        return new self(
            $m->id,
            $m->exam_id ?? null,
            $m->item_key ?? null,
            $m->max_points ?? null,
            $m->score_points ?? null,
            (bool) ($m->is_active ?? true),
            $format($m->created_at)
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'exam_id' => $this->exam_id,
            'item_key' => $this->item_key,
            'max_points' => $this->max_points,
            'score_points' => $this->score_points,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'exam_id' => $this->exam_id,
            'item_key' => $this->item_key,
            'max_points' => $this->max_points,
            'score_points' => $this->score_points,
            'is_active' => $this->is_active,
        ];
    }
}
