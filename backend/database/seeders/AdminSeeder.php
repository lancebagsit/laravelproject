<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (!Admin::where('email', 'admin@stjoseph.local')->exists()) {
            Admin::create([
                'name' => 'System Admin',
                'email' => 'admin@stjoseph.local',
                'password' => Hash::make('admin123'),
            ]);
        }
    }
}

