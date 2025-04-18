<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examinations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('academic_year_id')->constrained('academic_years');
            $table->date('exam_date');
            $table->integer('working_days')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('is_terminal')->default(false);
            $table->boolean('is_final')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examinations');
    }
};
