<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'is_current',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function examinations(): HasMany
    {
        return $this->hasMany(Examination::class);
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function gradeSettings(): HasMany
    {
        return $this->hasMany(GradeSetting::class);
    }

    public function divisionSettings(): HasMany
    {
        return $this->hasMany(DivisionSetting::class);
    }

    public function remarksSettings(): HasMany
    {
        return $this->hasMany(RemarksSetting::class);
    }

    public function extraActivities(): HasMany
    {
        return $this->hasMany(ExtraActivity::class);
    }
}
