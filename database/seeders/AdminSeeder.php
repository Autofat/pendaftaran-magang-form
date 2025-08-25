<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin KemenKes',
            'email' => 'admin@kemenkes.go.id',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        echo "Default admin created:\n";
        echo "Email: admin@kemenkes.go.id\n";
        echo "Password: admin123\n";
    }
}
