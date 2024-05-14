<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $account_sub_categories = [
            [
                'name' => "Kas/Bank",
                'account_category_id' => 1,
            ],
        ];

        DB::table('account_sub_categories')->insert(
            $account_sub_categories
        );
    }
}
