<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Activity extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'title',
        'description',
        'activity_date_g',
        'activity_date_h',
        'place',
        'created_by',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function media()
    {
        return $this->hasMany(ActivityMedia::class);
    }
}
