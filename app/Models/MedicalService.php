<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalService extends Model
{
    use HasFactory;
    protected $fillable = [
        'medical_facility_id',
        'name_ar',
        'name_en',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function medicalFacility()
    {
        return $this->belongsTo(MedicalFacility::class);
    }
}
