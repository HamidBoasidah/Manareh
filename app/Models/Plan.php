<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Plan extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'is_active',
    ];
}
