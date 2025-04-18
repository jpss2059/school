<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_extra_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('extra_activity_id')->constrained('extra_activities');
            $table->foreignId('academic_year_id')->constrained('academic_years');
            $table->string('grade')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_extra_activities');
    }
};
