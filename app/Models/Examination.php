<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'academic_year_id',
        'exam_date',
        'working_days',
        'status',
        'is_terminal',
        'is_final',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'is_terminal' => 'boolean',
        'is_final' => 'boolean',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }
}
