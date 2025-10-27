<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class CertificateTemplate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'name',
        'purpose',
        'html_template',
        'variables',
        'is_active',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
