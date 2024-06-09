<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'fullname' => "Super Admin 1",
                'name' => "SuperAdmin1",
                'dob'=> '1999-12-20',
                'address' => "Jalan Kuningan",
                'gender' => "Laki-Laki",
                'email' => "superadmin@gmail.com",
                'password' => Hash::make('123'),
                'join_date' => '1999-12-20',
                'role_id' => 1,
                'warehouse_id' => 1
            ],
            [
                'fullname' => "ADMIN 1",
                'name' => "Admin1",
                'dob'=> '1999-12-20',
                'address' => "Jalan Kembar",
                'gender' => "Laki-Laki",
                'email' => "admin1@gmail.com",
                'password' => Hash::make('123'),
                'join_date' => '1999-12-20',
                'role_id' => 2,
                'warehouse_id' => 1
            ],
            [
                'fullname' => "ADMIN 2",
                'name' => "Admin2",
                'dob'=> '1999-12-20',
                'address' => "Jalan Kembar",
                'gender' => "Laki-Laki",
                'email' => "admin2@gmail.com",
                'password' => Hash::make('123'),
                'join_date' => '1999-12-20',
                'role_id' => 2,
                'warehouse_id' => 2
            ],
            [
                'fullname' => "ADMIN 3",
                'name' => "Admin3",
                'dob'=> '1999-12-20',
                'address' => "Jalan Kembar",
                'gender' => "Laki-Laki",
                'email' => "admin3@gmail.com",
                'password' => Hash::make('123'),
                'join_date' => '1999-12-20',
                'role_id' => 2,
                'warehouse_id' => 3
            ],
            [
                'fullname' => "Kasir 1",
                'name' => "Kasir1",
                'dob'=> '1999-12-20',
                'address' => "Jalan Kertajaya",
                'gender' => "Perempuan",
                'email' => "kasir1@gmail.com",
                'password' => Hash::make('123'),
                'join_date' => '1999-12-20',
                'role_id' => 3,
                'warehouse_id' => 1
            ],
        ];

        DB::table('users')->insert(
            $users
        );
    }
}
