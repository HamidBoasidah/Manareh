<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Guardian extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_number',
        'whatsapp_number',
        'relation',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
