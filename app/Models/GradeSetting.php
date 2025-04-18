<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'percentage_from',
        'percentage_to',
        'grade',
        'grade_point',
        'remarks',
    ];

    protected $casts = [
        'percentage_from' => 'decimal:2',
        'percentage_to' => 'decimal:2',
        'grade_point' => 'decimal:2',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
