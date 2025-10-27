<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ExamType extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'name',
        'part_required',
        'is_active',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
