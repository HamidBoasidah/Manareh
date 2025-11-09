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
        'recorded_by',
        'is_active',
    ];

    protected $casts = [
        'date_g' => 'date',
        'is_active' => 'boolean',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    /**
     * Return primary role/name of the user (uses Spatie roles on User model).
     */
    public function getStaffRoleAttribute()
    {
        if (! $this->user) return null;
        if (method_exists($this->user, 'getRoleNames')) {
            return $this->user->getRoleNames()->first();
        }
        return null;
    }
}
