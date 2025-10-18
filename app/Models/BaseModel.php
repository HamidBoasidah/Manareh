<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by',
        'updated_by',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

}
