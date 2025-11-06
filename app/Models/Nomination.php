<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Nomination extends BaseModel
{
    use HasFactory;

    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'circle_id',
        'student_id',
        'exam_id',
        'nomination_type',
        'exam_type',
        'exam_part',
        'academic_year_id',
        'term_id',
        'nominated_by',
        'status',
        
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'status' => 'string',
        'exam_part' => 'integer',
        'exam_type' => 'string',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function nominatedBy()
    {
        return $this->belongsTo(User::class, 'nominated_by');
    }

    public function plan()
    {
        // kept for backward compatibility
        return $this->academicYear();
    }

    public function academicYear()
    {
        return $this->belongsTo(\App\Models\AcademicYear::class, 'academic_year_id');
    }

    public function exam()
    {
        return $this->belongsTo(\App\Models\Exam::class, 'exam_id');
    }
}
