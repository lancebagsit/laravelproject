<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;

class AnnouncementsSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['title' => 'Mass Schedule Update', 'content' => 'Beginning next month, new Sunday Mass at 5:00 PM.'],
            ['title' => 'Parish Festival', 'content' => 'Join us for our annual Parish Festival on July 8-10.'],
            ['title' => 'Bible Study Group', 'content' => 'Weekly Bible study every Thursday at 7:00 PM in the parish hall.'],
            ['title' => 'Volunteer Opportunities', 'content' => 'Volunteers needed for outreach program; contact the parish office.'],
        ];
        foreach ($data as $item) {
            Announcement::firstOrCreate(['title' => $item['title']], $item);
        }
    }
}

