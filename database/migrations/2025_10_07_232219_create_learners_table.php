<?php
// database/migrations/2024_01_01_000001_create_learners_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('learners', function (Blueprint $table) {
            $table->id();
            $table->string('psa_birth_certificate')->nullable();
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('extension_name')->nullable();
            $table->string('lrn')->nullable();
            $table->date('birthdate');
            $table->enum('gender', ['male', 'female']);
            $table->integer('age')->nullable();
            $table->enum('ip_community', ['yes', 'no'])->default('no');
            $table->string('ip_specify')->nullable();
            $table->enum('fourps_beneficiary', ['yes', 'no'])->default('no'); // Changed from 4ps_beneficiary
            $table->string('fourps_household_id')->nullable(); // Changed from 4ps_household_id
            $table->string('mother_tongue')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('learners');
    }
};