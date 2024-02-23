<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => "PT. Xavier Luna",
                'address' => "Jalan Ahmad Yani"
            ],
            [
                'name' => "PT. Akai Sentosa",
                'address' => "Jalan Benowo"
            ],
            [
                'name' => "PT. Zilong Inspire",
                'address' => "Jalan Katedral"
            ],
        ];

        DB::table('customers')->insert(
            $customers
        );
    }
}
