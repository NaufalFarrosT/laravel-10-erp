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
                'Code'=>"Guest",
                'name' => "Guest",
                'address' => "-"
            ],
        ];

        DB::table('customers')->insert(
            $customers
        );
    }
}
