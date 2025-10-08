<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Principal Admin',
            'email' => 'principal',
            'password' => Hash::make('admin'),
            'role' => 'principal',
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: principal');
        $this->command->info('Password: admin');
    }
}