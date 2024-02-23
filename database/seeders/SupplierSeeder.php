<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => "PT Plastik",
                'address' => "Jalan Ahmad Yani"
            ],
            [
                'name' => "PT ATK Sentosa",
                'address' => "Jalan Benowo"
            ],
            [
                'name' => "PT B",
                'address' => "Jalan Katedral"
            ],
        ];

        DB::table('suppliers')->insert(
            $suppliers
        );
    }
}
