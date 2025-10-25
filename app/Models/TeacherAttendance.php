<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class TeacherAttendance extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'circle_id',
        'user_id',
        'date_g',
        'date_h',
        'status',
        'notes',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
