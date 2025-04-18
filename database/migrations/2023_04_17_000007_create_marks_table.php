<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('examination_id')->constrained('examinations');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->foreignId('academic_year_id')->constrained('academic_years');
            $table->foreignId('class_id')->constrained('classes');
            $table->foreignId('section_id')->nullable()->constrained('sections');
            $table->decimal('obtained_marks', 8, 2)->default(0);
            $table->decimal('percentage', 8, 2)->default(0);
            $table->string('grade')->nullable();
            $table->decimal('grade_point', 8, 2)->nullable();
            $table->string('remarks')->nullable();
            $table->boolean('is_absent')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
