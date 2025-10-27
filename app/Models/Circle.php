<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Circle extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'classification_id',
        'name',
        'capacity',
        'notes',
        'is_active',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function classification()
    {
        return $this->belongsTo(CircleClassification::class, 'classification_id');
    }

    public function staffAssignments()
    {
        return $this->hasMany(StaffAssignment::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
