<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => "Bulpen Standard",
                'price' => "3000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 2,
            ],
            [
                'name' => "Bulpen Standard",
                'price' => "25000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 3,
            ],
            [
                'name' => "Bulpen Pilot",
                'price' => "2500",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 2,
            ],
            [
                'name' => "Bulpen Pilot",
                'price' => "22000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 3,
            ],
            [
                'name' => "Spidol Hitam BG",
                'price' => "6000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 2,
            ],
            [
                'name' => "Spidol Hitam BG",
                'price' => "55000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 3,
            ],
            [
                'name' => "Kursi Ergonomis Rexus NC 1",
                'price' => "1150000",
                'stock' => 0,
                'category_id' => 2,
                'unit_id' => 2,
            ],
            [
                'name' => "Kursi Ergonomis Rexus NC 2",
                'price' => "1250000",
                'stock' => 0,
                'category_id' => 2,
                'unit_id' => 2,
            ],
            [
                'name' => "Kursi Ergonomis Fantech OCA 258",
                'price' => "900000",
                'stock' => 0,
                'category_id' => 2,
                'unit_id' => 2,
            ],
            [
                'name' => "Kursi Ergonomis Fantech OCA 259 pro",
                'price' => "1900000",
                'stock' => 0,
                'category_id' => 2,
                'unit_id' => 2,
            ],
            [
                'name' => "Headset Rexus Vonix C1",
                'price' => "150000",
                'stock' => 0,
                'category_id' => 3,
                'unit_id' => 2,
            ],
            [
                'name' => "Headset Rexus Vonix",
                'price' => "1250000",
                'stock' => 0,
                'category_id' => 3,
                'unit_id' => 3,
            ],
        ];

        DB::table('items')->insert(
            $items
        );
    }
}
