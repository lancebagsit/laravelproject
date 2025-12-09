<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priest;

class PriestsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Rev. Fr. Ronaldo M. Macale', 'image' => '/img/priest.jpg', 'description' => 'Parish Priest'],
            ['name' => 'Rev. Fr. Antonio Ramirez', 'image' => '/img/priest.jpg', 'description' => 'Assistant Priest'],
            ['name' => 'Rev. Fr. Miguel de la Cruz', 'image' => '/img/priest.jpg', 'description' => 'Assistant Priest'],
        ];
        foreach ($data as $item) {
            Priest::firstOrCreate(['name' => $item['name']], $item);
        }
    }
}

