<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'roll_number',
        'class_id',
        'section_id',
        'gender',
        'date_of_birth',
        'address',
        'phone',
        'email',
        'parent_name',
        'parent_phone',
        'parent_email',
        'mbl_number',
        'is_active',
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function extraActivities(): HasMany
    {
        return $this->hasMany(StudentExtraActivity::class);
    }
}
