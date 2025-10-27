<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'name',
        'type',
        'description',
        'is_active',
    ];

    /**
     * The mosque this program belongs to.
     */
    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }
}
