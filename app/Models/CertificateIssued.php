<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class CertificateIssued extends BaseModel
{
    use HasFactory;

    // This migration has no specific columns yet; keep fillable minimal
    protected $fillable = [];
}
