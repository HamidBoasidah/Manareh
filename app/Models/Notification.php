<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Notification extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'recipient_type',
        'recipient_id',
        'channel',
        'template_id',
        'payload',
        'status',
        'sent_at',
        'error',
        'is_active',
    ];

    public function template()
    {
        return $this->belongsTo(MessageTemplate::class, 'template_id');
    }
}
