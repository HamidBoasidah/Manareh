<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class AcademicYear extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'name',
        'start_date_g',
        'end_date_g',
        'start_date_h',
        'end_date_h',
        'is_active',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function terms()
    {
        return $this->hasMany(Term::class);
    }
}
