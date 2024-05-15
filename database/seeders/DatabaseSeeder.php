<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            WarehouseSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            UnitSeeder::class,
            SupplierSeeder::class,
            AccountCategorySeeder::class,
            AccountSubCategorySeeder::class,
            SubAccountSeeder::class,
            ItemSeeder::class,
            CustomerSeeder::class,
            TransactionTypeSeeder::class,
        ]);
    }
}
