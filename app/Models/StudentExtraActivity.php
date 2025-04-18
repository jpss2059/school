<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentExtraActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'extra_activity_id',
        'academic_year_id',
        'grade',
        'remarks',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function extraActivity(): BelongsTo
    {
        return $this->belongsTo(ExtraActivity::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
