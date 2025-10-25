<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class StudentAttendance extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'circle_id',
        'student_id',
        'date_g',
        'date_h',
        'status',
        'reason',
        'recorded_by',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
