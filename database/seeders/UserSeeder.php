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
                'fullname' => "Super Admin",
                'name' => "Super Admin",
                'dob'=> '1999-12-20',
                'address' => "Jalan Kuningan",
                'gender' => "Laki-Laki",
                'email' => "superadmin@gmail.com",
                'password' => Hash::make('123'),
                'join_date' => '1999-12-20',
                'role_id' => 1
            ],
            [
                'fullname' => "Admin",
                'name' => "Admin",
                'dob'=> '1999-12-20',
                'address' => "Jalan Kembar",
                'gender' => "Laki-Laki",
                'email' => "admin@gmail.com",
                'password' => Hash::make('123'),
                'join_date' => '1999-12-20',
                'role_id' => 2
            ],
            [
                'fullname' => "Staff",
                'name' => "Staff",
                'dob'=> '1999-12-20',
                'address' => "Jalan Kertajaya",
                'gender' => "Perempuan",
                'email' => "staff@gmail.com",
                'password' => Hash::make('123'),
                'join_date' => '1999-12-20',
                'role_id' => 3
            ],
        ];

        DB::table('users')->insert(
            $users
        );
    }
}
