<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingPeriod extends Model
{
    use HasFactory;
    protected $fillable = [
        'medical_facility_id',
        'day',
        'from_time',
        'to_time',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'from_time' => 'datetime:H:i',
        'to_time' => 'datetime:H:i',
    ];

    public function medicalFacility()
    {
        return $this->belongsTo(MedicalFacility::class);
    }
}
