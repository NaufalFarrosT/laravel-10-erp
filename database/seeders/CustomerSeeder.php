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
                'code'=>"Guest",
                'name' => "Non-Member",
                'address' => "-"
            ],
        ];

        DB::table('customers')->insert(
            $customers
        );
    }
}
