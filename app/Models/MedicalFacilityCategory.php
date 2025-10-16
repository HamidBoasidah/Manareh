<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalFacilityCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'is_active',
        'is_parentable',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_parentable' => 'boolean',
    ];

    public function medicalFacilities()
    {
        return $this->hasMany(MedicalFacility::class);
    }
}
