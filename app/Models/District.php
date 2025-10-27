<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class District extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'governorate_id',
        'created_by',
        'updated_by',
        'is_active',
    ];

    // لا توجد خصائص تحويل إضافية مطلوبة هنا

    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

}
