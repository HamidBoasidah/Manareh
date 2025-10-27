<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class ExamItem extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'item_key',
        'max_points',
        'score_points',
        'notes',
        'is_active',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
