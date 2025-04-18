<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extra_activities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('shortcut')->nullable();
            $table->foreignId('academic_year_id')->constrained('academic_years');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extra_activities');
    }
};
