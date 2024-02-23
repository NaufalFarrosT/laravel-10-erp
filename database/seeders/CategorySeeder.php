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
                'name' => "Persediaan",
            ],
            [
                'name' => "Bahan",
            ],
            [
                'name' => "Non-Persediaan",
            ],
        ];

        DB::table('categories')->insert(
            $categories
        );
    }
}
