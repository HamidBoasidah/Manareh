<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class MessageTemplate extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'code',
        'channel',
        'subject',
        'body',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
