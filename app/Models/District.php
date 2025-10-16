<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'is_active',
        'governorate_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function medicalFacilities()
    {
        return $this->hasMany(MedicalFacility::class);
    }
}
