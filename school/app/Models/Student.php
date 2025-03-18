<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    Schema::create('students', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('phone')->nullable();
        $table->date('dob');
        $table->string('gender');
        $table->string('address')->nullable();
        $table->string('photo')->nullable();
        $table->timestamps();
    });
}
