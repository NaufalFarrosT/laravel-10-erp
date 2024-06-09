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
                'selling_price' => "3000",
                'buying_price' => "2000",
                'item_capital' => 0,
                'profit' => "1000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 2,
            ],
            [
                'name' => "Bulpen Standard",
                'selling_price' => "25000",
                'buying_price' => "16000",
                'item_capital' => 0,
                'profit' => "9000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 3,
            ],
            [
                'name' => "Bulpen Pilot",
                'selling_price' => "2500",
                'buying_price' => "1500",
                'item_capital' => 0,
                'profit' => "1000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 2,
            ],
            [
                'name' => "Bulpen Pilot",
                'selling_price' => "22000",
                'buying_price' => "14000",
                'item_capital' => 0,
                'profit' => "8000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 3,
            ],
            [
                'name' => "Spidol Hitam BG",
                'selling_price' => "6000",
                'buying_price' => "3500",
                'item_capital' => 0,
                'profit' => "2500",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 2,
            ],
            [
                'name' => "Spidol Hitam BG",
                'selling_price' => "55000",
                'buying_price' => "31000",
                'item_capital' => 0,
                'profit' => "24000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 3,
            ],
            [
                'name' => "Kursi Ergonomis Rexus NC 1",
                'selling_price' => "1150000",
                'buying_price' => "750000",
                'item_capital' => 0,
                'profit' => "400000",
                'stock' => 0,
                'category_id' => 2,
                'unit_id' => 2,
            ],
            [
                'name' => "Kursi Ergonomis Rexus NC 2",
                'selling_price' => "1250000",
                'buying_price' => "1000000",
                'item_capital' => 0,
                'profit' => "250000",
                'stock' => 0,
                'category_id' => 2,
                'unit_id' => 2,
            ],
            [
                'name' => "Kursi Ergonomis Fantech OCA 258",
                'selling_price' => "900000",
                'buying_price' => "750000",
                'item_capital' => 0,
                'profit' => "150000",
                'stock' => 0,
                'category_id' => 2,
                'unit_id' => 2,
            ],
            [
                'name' => "Kursi Ergonomis Fantech OCA 259 pro",
                'selling_price' => "1900000",
                'buying_price' => "1500000",
                'item_capital' => 0,
                'profit' => "400000",
                'stock' => 0,
                'category_id' => 2,
                'unit_id' => 2,
            ],
            [
                'name' => "Headset Rexus Vonix C1",
                'selling_price' => "150000",
                'buying_price' => "100000",
                'item_capital' => 0,
                'profit' => "50000",
                'stock' => 0,
                'category_id' => 3,
                'unit_id' => 2,
            ],
            [
                'name' => "Headset Rexus Vonix",
                'selling_price' => "1250000",
                'buying_price' => "85000",
                'item_capital' => 0,
                'profit' => "40000",
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
