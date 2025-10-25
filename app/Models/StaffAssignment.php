<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class StaffAssignment extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'circle_id',
        'role_in_circle',
        'start_at',
        'end_at',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }
}
