<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('academic_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('school_year');
            $table->integer('grade_level');
            $table->string('subject');
            $table->decimal('grade', 5, 2);
            $table->enum('status', ['passed', 'failed']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('academic_records');
    }
};