<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Enrollment extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'circle_id',
        'student_id',
        'status',
        'joined_at',
        'left_at',
        'is_active',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
