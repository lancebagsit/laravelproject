<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class SchedulesSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['time' => '6:00am', 'language' => 'Tagalog'],
            ['time' => '7:30am', 'language' => 'Tagalog'],
            ['time' => '9:00am', 'language' => 'English'],
            ['time' => '10:30am', 'language' => 'Tagalog'],
            ['time' => '12:30pm', 'language' => 'Tagalog'],
            ['time' => '2:00pm', 'language' => 'Tagalog'],
            ['time' => '3:30pm', 'language' => 'Tagalog'],
            ['time' => '5:00pm', 'language' => 'Tagalog'],
            ['time' => '6:30pm', 'language' => 'Tagalog'],
            ['time' => '8:00pm', 'language' => 'English'],
        ];
        foreach ($rows as $item) {
            Schedule::firstOrCreate($item, $item);
        }
    }
}

