<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentBlock extends Model
{
    use HasFactory;
    protected $fillable = [
        'type',
        'title',
        'slug',
        'description',
        'content',
        'address',
        'phone',
        'mobile',
        'email',
        'whatsapp_url',
        'whatsapp_label',
        'phone_number',
        'phone_label',
        'attachment',
        'is_active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
