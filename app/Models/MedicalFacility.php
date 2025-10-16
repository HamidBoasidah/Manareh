<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalFacility extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'attachment',
        'address',
        'phone_number',
        'landline_number',
        'whatsapp_number',
        'governorate_id',
        'district_id',
        'area_id',
        'medical_facility_category_id',
        'parent_id',
        'is_general',
        'specialty_id',
        'is_active',
        'created_by',
        'updated_by',
        'facility_ownership_id',
    ];

    protected $casts = [
        'is_general' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function facilityOwnership()
    {
        return $this->belongsTo(FacilityOwnership::class);
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function category()
    {
        return $this->belongsTo(MedicalFacilityCategory::class, 'medical_facility_category_id');
    }


    public function parent()
    {
        return $this->belongsTo(MedicalFacility::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MedicalFacility::class, 'parent_id');
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    public function medicalServices()
    {
        return $this->hasMany(MedicalService::class);
    }

    public function periods()
    {
        return $this->hasMany(WorkingPeriod::class, 'medical_facility_id');
    }
}
