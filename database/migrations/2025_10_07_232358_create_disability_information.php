<?php
// database/migrations/2024_01_01_000004_create_disability_information_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('disability_information', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->constrained()->onDelete('cascade');
            $table->enum('disability_type', [
                'none', 'physical', 'learning', 'visual', 
                'hearing', 'speech', 'other'
            ])->default('none');
            $table->text('special_requirements')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('disability_information');
    }
};