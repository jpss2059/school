<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExtraActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shortcut',
        'academic_year_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function studentExtraActivities(): HasMany
    {
        return $this->hasMany(StudentExtraActivity::class);
    }
}
