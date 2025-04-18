<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('division_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained('academic_years');
            $table->string('division_name');
            $table->decimal('percentage_from', 8, 2);
            $table->decimal('percentage_to', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('division_settings');
    }
};
