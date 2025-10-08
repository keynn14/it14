<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transferees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('previous_school');
            $table->text('previous_school_address');
            $table->enum('school_type', ['public', 'private']);
            $table->integer('previous_grade');
            $table->integer('desired_grade');
            $table->string('last_school_year');
            $table->text('transfer_reason');
            $table->string('form_137_path');
            $table->string('good_moral_path');
            $table->string('birth_certificate_path')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('student_id');
            $table->index('status');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transferees');
    }
};