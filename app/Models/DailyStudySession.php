<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use App\Models\DailyStudy;

class DailyStudySession extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'circle_id',
        'session_date_g',
        'session_date_h',
        'created_by',
        'is_active',
    ];

    protected $casts = [
        'session_date_g' => 'date',
        'is_active' => 'boolean',
    ];

    public function circle()
    {
        return $this->belongsTo(Circle::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function studies()
    {
        return $this->hasMany(DailyStudy::class, 'session_id');
    }
}
