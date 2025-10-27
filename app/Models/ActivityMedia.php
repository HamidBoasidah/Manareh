<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ActivityMedia extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'file_url',
        'caption',
        'is_active',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
