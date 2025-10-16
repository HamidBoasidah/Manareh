<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }

    public function areas()
    {
        return $this->hasManyThrough(Area::class, District::class);
    }

    public function medicalFacilities()
    {
        return $this->hasMany(MedicalFacility::class);
    }
}
