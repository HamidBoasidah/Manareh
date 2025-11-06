<?php

namespace App\DTOs;

use App\Models\Exam;
use App\DTOs\ExamItemDTO;

class ExamDTO extends BaseDTO
{
    public $id;
    public $circle_id;
    public $circle_name;
    public $student_id;
    public $student_name;
    public $exam_type;
    public $stage;
    public $juzz;
    public $exam_date_g;
    public $exam_date_h;
    public $total_points;
    public $total_grade;
    public $remarks;
    public $is_active;
    public $created_at;
    public $items;

    public function __construct(
        $id,
        $circle_id = null,
        $circle_name = null,
        $student_id = null,
        $student_name = null,
        $exam_type = null,
        $stage = null,
        $juzz = null,
        $exam_date_g = null,
        $exam_date_h = null,
        $total_points = null,
        $total_grade = null,
        $remarks = null,
        $is_active = true,
        $created_at = null
    ) {
        $this->id = $id;
        $this->circle_id = $circle_id;
        $this->circle_name = $circle_name;
        $this->student_id = $student_id;
        $this->student_name = $student_name;
        $this->exam_type = $exam_type;
        $this->stage = $stage;
        $this->juzz = $juzz;
        $this->exam_date_g = $exam_date_g;
        $this->exam_date_h = $exam_date_h;
        $this->total_points = $total_points;
        $this->total_grade = $total_grade;
        $this->remarks = $remarks;
        $this->is_active = $is_active;
        $this->created_at = $created_at;
    }

    public static function fromModel(Exam $exam): self
    {
        $exam->loadMissing([
            'circle:id,name',
            'student:id,user_id',
            'student.user:id,name',
        ]);

        // ensure items are loaded
        $exam->loadMissing(['examItems']);

        $format = function ($val) {
            if ($val instanceof \DateTimeInterface) {
                return $val->format('Y-m-d H:i:s');
            }
            return $val;
        };

        $items = null;
        if ($exam->relationLoaded('examItems')) {
            $items = array_map(function ($m) {
                return ExamItemDTO::fromModel($m)->toArray();
            }, $exam->examItems->all());
        }

        return new self(
            $exam->id,
            $exam->circle_id ?? null,
            $exam->circle?->name ?? null,
            $exam->student_id ?? null,
            $exam->student?->user?->name ?? null,
            $exam->exam_type ?? null,
            $exam->stage ?? null,
            $exam->juzz ?? null,
            $exam->exam_date_g ?? null,
            $exam->exam_date_h ?? null,
            $exam->total_points ?? null,
            $exam->total_grade ?? null,
            $exam->remarks ?? null,
            $exam->is_active ?? null,
            $format($exam->created_at),
            $items
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'circle_id' => $this->circle_id,
            'circle_name' => $this->circle_name,
            'student_id' => $this->student_id,
            'student_name' => $this->student_name,
            'exam_type' => $this->exam_type,
            'stage' => $this->stage,
            'juzz' => $this->juzz,
            'exam_date_g' => $this->exam_date_g,
            'exam_date_h' => $this->exam_date_h,
            'total_points' => $this->total_points,
            'total_grade' => $this->total_grade,
            'remarks' => $this->remarks,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'items' => $this->items,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'student_name' => $this->student_name,
            'circle_name' => $this->circle_name,
            'exam_type' => $this->exam_type,
            'stage' => $this->stage,
            'juzz' => $this->juzz,
            'exam_date_g' => $this->exam_date_g,
            'exam_date_h' => $this->exam_date_h,
            'total_grade' => $this->total_grade,
            'is_active' => $this->is_active,
        ];
    }
}
