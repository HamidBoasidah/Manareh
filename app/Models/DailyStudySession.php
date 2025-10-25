<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class DailyStudySession extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'circle_id',
        'session_date_g',
        'session_date_h',
        'created_by',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
