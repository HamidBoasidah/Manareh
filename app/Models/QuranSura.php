<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class QuranSura extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'ayah_count',
        'is_active',
    ];
}
