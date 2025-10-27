<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Area extends BaseModel
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
        'district_id',
        'created_by',
        'updated_by',
        'is_active',
    ];

    // لا توجد خصائص تحويل إضافية مطلوبة هنا

    public function district()
    {
        return $this->belongsTo(District::class);
    }

}
