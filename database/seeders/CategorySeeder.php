<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => "Alat Tulis",
            ],
            [
                'name' => "Kursi",
            ],
            [
                'name' => "Headset",
            ],
        ];

        DB::table('categories')->insert(
            $categories
        );
    }
}
