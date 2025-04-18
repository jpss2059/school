<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'class_id',
        'full_marks',
        'pass_marks',
        'credit_hours',
        'is_active',
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }
}
