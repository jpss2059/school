<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemarksSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'percentage_from',
        'percentage_to',
        'remarks',
        'is_auto',
    ];

    protected $casts = [
        'percentage_from' => 'decimal:2',
        'percentage_to' => 'decimal:2',
        'is_auto' => 'boolean',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
