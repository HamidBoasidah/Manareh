<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{

    protected $fillable = [
        'created_by',
        'updated_by',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

}
