<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sub_accounts = [
            [
                'name' => "Tunai",
                'balance' => 0,
                'account_sub_category_id' => 1
            ],
            [
                'name' => "BANK BCA",
                'balance' => 0,
                'account_sub_category_id' => 1
            ],
            [
                'name' => "BANK BRI",
                'balance' => 0,
                'account_sub_category_id' => 1
            ],
        ];

        DB::table('sub_accounts')->insert(
            $sub_accounts
        );
    }
}
