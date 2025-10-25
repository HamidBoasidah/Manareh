<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Term extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'name',
        'start_date_g',
        'end_date_g',
        'start_date_h',
        'end_date_h',
        'is_active',
    ];

    /**
     * The academic year this term belongs to.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
