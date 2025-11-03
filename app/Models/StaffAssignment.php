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
        'role_id',
        'start_at',
        'end_at',
        'notes',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Backwards-compatible accessor: keep `role_in_circle` attribute available
     * as the role's name so existing code that expects `role_in_circle` works.
     */
    public function getRoleInCircleAttribute()
    {
        return $this->role?->name;
    }
}
