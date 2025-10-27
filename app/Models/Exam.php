<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Exam extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'circle_id',
        'student_id',
        'exam_type_id',
        'exam_date_g',
        'exam_date_h',
        'juzz',
        'total_points',
        'total_grade',
        'remarks',
        'is_active',
    ];
}
