<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transaction_types = [
            [
                'name' => "Pemasukan",
            ],
            [
                'name' => "Pengeluaran",
            ],
        ];

        DB::table('transaction_types')->insert(
            $transaction_types
        );
    }
}
