<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DivisionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'division_name',
        'percentage_from',
        'percentage_to',
    ];

    protected $casts = [
        'percentage_from' => 'decimal:2',
        'percentage_to' => 'decimal:2',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
