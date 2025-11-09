<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Exam extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'nomination_id',
        'circle_id',
        'student_id',
        'exam_type',
        'exam_date_g',
        'exam_date_h',
        'juzz',
        'stage',
        'total_points',
        'total_grade',
        'remarks',
        'is_active',
    ];

    // allowed exam types
    public const TYPE_STAGE = 'stage';
    public const TYPE_JUZZ = 'juzz';

    public static function examTypes(): array
    {
        return [self::TYPE_STAGE, self::TYPE_JUZZ];
    }

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function examItems()
    {
        return $this->hasMany(\App\Models\ExamItem::class);
    }

    public function nomination()
    {
        return $this->belongsTo(\App\Models\Nomination::class);
    }
}
