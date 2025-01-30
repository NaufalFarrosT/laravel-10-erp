<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stores = [
            [
                'name' => "Toko Utama",
                'address' => "Jalan Ahmad Yani"
            ],
            [
                'name' => "Toko 01",
                'address' => "Jalan Benowo"
            ],
            [
                'name' => "Toko 02",
                'address' => "Jalan Katedral"
            ],
        ];

        DB::table('stores')->insert(
            $stores
        );
    }
}
