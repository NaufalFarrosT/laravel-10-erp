<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $accounts = [
            [
                'name' => "Tunai",
                'balance' => 1500000,
            ],
            [
                'name' => "BANK BCA",
                'balance' => 0,
            ],
            [
                'name' => "BANK BRI",
                'balance' => 1500000,
            ],
        ];

        DB::table('accounts')->insert(
            $accounts
        );
    }
}
