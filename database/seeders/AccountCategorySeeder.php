<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $account_categories = [
            [
                'name' => "Harta Tetap",
            ],
        ];

        DB::table('account_categories')->insert(
            $account_categories
        );
    }
}
