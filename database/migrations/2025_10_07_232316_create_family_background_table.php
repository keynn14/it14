<?php
// database/migrations/2024_01_01_000003_create_family_backgrounds_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('family_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learner_id')->constrained()->onDelete('cascade');
            
            // Father's Information
            $table->string('father_last_name')->nullable();
            $table->string('father_first_name')->nullable();
            $table->string('father_middle_name')->nullable();
            $table->string('father_contact')->nullable();
            
            // Mother's Information
            $table->string('mother_last_name')->nullable();
            $table->string('mother_first_name')->nullable();
            $table->string('mother_middle_name')->nullable();
            $table->string('mother_contact')->nullable();
            
            // Guardian's Information
            $table->string('guardian_last_name');
            $table->string('guardian_first_name');
            $table->string('guardian_middle_name')->nullable();
            $table->string('guardian_contact');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('family_backgrounds');
    }
};