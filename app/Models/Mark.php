<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'examination_id',
        'subject_id',
        'academic_year_id',
        'class_id',
        'section_id',
        'obtained_marks',
        'percentage',
        'grade',
        'grade_point',
        'remarks',
        'is_absent',
    ];

    protected $casts = [
        'obtained_marks' => 'decimal:2',
        'percentage' => 'decimal:2',
        'grade_point' => 'decimal:2',
        'is_absent' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function examination(): BelongsTo
    {
        return $this->belongsTo(Examination::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
}
