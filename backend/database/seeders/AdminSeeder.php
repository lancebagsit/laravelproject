<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@stjoseph.local'],
            ['name' => 'System Admin', 'password' => Hash::make('admin123')]
        );

        Admin::updateOrCreate(
            ['email' => 'admin@superduper.local'],
            ['name' => 'Alt Admin', 'password' => Hash::make('admin123')]
        );
    }
}
