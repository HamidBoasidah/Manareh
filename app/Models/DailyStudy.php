<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class DailyStudy extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'student_id',
        'hifz_from_sura_id',
        'hifz_from_ayah',
        'hifz_to_sura_id',
        'hifz_to_ayah',
        'hifz_pages',
        'murajaah_from_sura_id',
        'murajaah_from_ayah',
        'murajaah_to_sura_id',
        'murajaah_to_ayah',
        'murajaah_pages',
        'points',
        'attendance_status',
        'notes',
        'is_active',
    ];

    public function session()
    {
        return $this->belongsTo(DailyStudySession::class, 'session_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

}
