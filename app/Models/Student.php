<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Student extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mosque_id',
        'guardian_id',
        'birth_date',
        'address',
        'phone_number',
        'whatsapp_number',
        'nationality',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guardian()
    {
        return $this->belongsTo(Guardian::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
