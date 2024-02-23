<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            [
                'name' => "Kilogram",
            ],
            [
                'name' => "Pcs",
            ],
            [
                'name' => "Box",
            ],
        ];

        DB::table('units')->insert(
            $units
        );
    }
}
