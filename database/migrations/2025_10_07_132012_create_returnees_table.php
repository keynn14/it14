<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
Schema::create('returnees', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained()->onDelete('cascade');
    $table->string('previous_school_year');
    $table->integer('previous_grade_level');
    $table->integer('new_grade_level');
    $table->text('reason_for_return')->nullable();
    $table->json('academic_status')->nullable();
    $table->string('documents_path')->nullable();
    $table->text('remarks')->nullable();
    $table->timestamps();
});
    }

    public function down()
    {
        Schema::dropIfExists('returnees');
    }
};