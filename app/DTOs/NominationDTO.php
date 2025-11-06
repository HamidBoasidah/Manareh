<?php

namespace App\DTOs;

use App\Models\Nomination;

class NominationDTO extends BaseDTO
{
    public $id;
    public $circle_id;
    public $circle_name;
    public $student_id;
    public $student_name;
    public $nomination_type;
    public $academic_year_id;
    public $academic_year_name;
    public $term_id;
    public $nominated_by;
    public $nominated_by_name;
    public $status;
    public $notes;
    public $is_active;
    public $created_at;

    public function __construct(
        $id,
        $circle_id = null,
        $circle_name = null,
        $student_id = null,
        $student_name = null,
        $nomination_type = null,
    $academic_year_id = null,
    $academic_year_name = null,
        $term_id = null,
        $nominated_by = null,
        $nominated_by_name = null,
        $status = null,
        $notes = null,
        $is_active = true,
        $created_at = null
    ) {
        $this->id = $id;
        $this->circle_id = $circle_id;
        $this->circle_name = $circle_name;
        $this->student_id = $student_id;
        $this->student_name = $student_name;
        $this->nomination_type = $nomination_type;
    $this->academic_year_id = $academic_year_id;
    $this->academic_year_name = $academic_year_name;
        $this->term_id = $term_id;
        $this->nominated_by = $nominated_by;
        $this->nominated_by_name = $nominated_by_name;
        $this->status = $status;
        $this->notes = $notes;
        $this->is_active = $is_active;
        $this->created_at = $created_at;
    }

    public static function fromModel(Nomination $n): self
    {
        $n->loadMissing([
            'circle:id,name',
            'student:id,user_id',
            'student.user:id,name',
            'academicYear:id,name',
            'nominatedBy:id,name',
        ]);

        $format = function ($val) {
            if ($val instanceof \DateTimeInterface) {
                return $val->format('Y-m-d H:i:s');
            }
            return $val;
        };

        return new self(
            $n->id,
            $n->circle_id,
            $n->circle?->name ?? null,
            $n->student_id,
            $n->student?->user?->name ?? null,
            $n->nomination_type,
            $n->academic_year_id ?? null,
            $n->academicYear?->name ?? null,
            $n->term_id ?? null,
            $n->nominated_by ?? null,
            $n->nominatedBy?->name ?? null,
            $n->status ?? \App\Models\Nomination::STATUS_SUBMITTED,
            $n->notes ?? null,
            $n->is_active ?? null,
            $format($n->created_at)
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
            'nomination_type' => $this->nomination_type,
            'academic_year_id' => $this->academic_year_id,
            'academic_year_name' => $this->academic_year_name,
            'term_id' => $this->term_id,
            'nominated_by' => $this->nominated_by,
            'nominated_by_name' => $this->nominated_by_name,
            'status' => $this->status,
            'notes' => $this->notes,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
        ];
    }

    public function toIndexArray(): array
    {
        return [
            'id' => $this->id,
            'student_name' => $this->student_name,
            'circle_name' => $this->circle_name,
            'nomination_type' => $this->nomination_type,
            'academic_year_name' => $this->academic_year_name,
            'status' => $this->status,
            'is_active' => $this->is_active,
        ];
    }
}
