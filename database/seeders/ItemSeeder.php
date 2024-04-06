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
                'category_id' => 3,
                'unit_id' => 2,
            ],
            [
                'name' => "Bulpen Standard",
                'price' => "3000",
                'stock' => 0,
                'category_id' => 3,
                'unit_id' => 3,
            ],
            [
                'name' => "Kursi Ergonomis Rexuc NC 1",
                'price' => "1150000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 2,
            ],
            [
                'name' => "Kursi Ergonomis Rexuc NC 2",
                'price' => "1250000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 2,
            ],
            [
                'name' => "Headset Rexus Vonix",
                'price' => "150000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 2,
            ],
            [
                'name' => "Headset Rexus Vonix",
                'price' => "1250000",
                'stock' => 0,
                'category_id' => 1,
                'unit_id' => 3,
            ],
        ];

        DB::table('items')->insert(
            $items
        );
    }
}
