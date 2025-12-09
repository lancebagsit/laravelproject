<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryItem;

class GalleryItemsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Ambag ng Pasko', 'url' => '/img/AMBAG.jpg'],
            ['title' => 'Bloodletting Activity', 'url' => '/img/BLOODLETTING.JPG'],
            ['title' => 'DSWD Workshop', 'url' => '/img/DSWD.jpg'],
            ['title' => 'Pan De San Jose', 'url' => '/img/pan-de-san-jose.jpg'],
            ['title' => 'PPC Encounter', 'url' => '/img/ENCOUNTER.jpg'],
            ['title' => 'Bagyong Carina Relief', 'url' => '/img/bagyong-carina.jpg'],
        ];
        foreach ($items as $item) {
            GalleryItem::firstOrCreate(['title' => $item['title']], $item);
        }
    }
}

