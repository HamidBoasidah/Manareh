<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class CircleClassification extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function circles()
    {
        return $this->hasMany(Circle::class, 'classification_id');
    }
}
