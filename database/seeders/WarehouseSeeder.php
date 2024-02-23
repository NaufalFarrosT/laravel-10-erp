<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $warehouses = [
            [
                'name' => "Gudang Utama",
                'address' => "Jalan Ahmad Yani"
            ],
            [
                'name' => "Gudang 01",
                'address' => "Jalan Benowo"
            ],
            [
                'name' => "Gudang 02",
                'address' => "Jalan Katedral"
            ],
        ];

        DB::table('warehouses')->insert(
            $warehouses
        );
    }
}
