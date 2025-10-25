<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Mosque extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'address',
        'phone',
        'notes',
    ];

    public function circles()
    {
        return $this->hasMany(Circle::class);
    }

    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }
}
