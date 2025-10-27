<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Nomination extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'circle_id',
        'student_id',
        'nomination_type',
        'month_ref',
        'term_id',
        'nominated_by',
        'status',
        'approved_by',
        'approved_at',
        'notes',
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

    public function nominatedBy()
    {
        return $this->belongsTo(User::class, 'nominated_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
