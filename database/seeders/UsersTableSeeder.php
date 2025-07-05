<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
   public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'email' => 'admin@rumahsakitfathmamedika.com',
                'password' => Hash::make('admin123'),
                'activated' => 1,
                'created_by' => null,
                'activated_at' => '2025-06-24 08:31:00',
                'last_login' => '2025-06-24 08:31:00',
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'created_at' => '2025-03-25 05:19:00',
                'updated_at' => '2025-06-24 08:31:00',
                'deleted_at' => null,
                'manager_id' => null,
                'employee_num' => 'ADM001',
                'username' => 'admin',
                'notes' => 'System Administrator',
                'company_id' => 1,
                'remember_token' => null,
                'role_id' => 1, // admin
            ],
            [
                'id' => 2,
                'email' => 'sirs@rumahsakitfathmamedika.com',
                'password' => Hash::make('password1'),
                'activated' => 1,
                'created_by' => 1,
                'activated_at' => '2025-06-24 08:31:00',
                'last_login' => '2025-06-24 08:31:00',
                'first_name' => 'Tim',
                'last_name' => 'IT',
                'created_at' => '2025-03-25 05:19:00',
                'updated_at' => '2025-06-24 08:31:00',
                'deleted_at' => null,
                'manager_id' => null,
                'employee_num' => null,
                'username' => 'SIRS',
                'notes' => null,
                'company_id' => 1,
                'remember_token' => null,
                'role_id' => 4, // manager_it
            ],
            [
                'id' => 3,
                'email' => 'kasubag.logistikumum@rumahsakitfathmamedika.com',
                'password' => Hash::make('password2'),
                'activated' => 1,
                'created_by' => 1,
                'activated_at' => '2025-06-24 07:52:00',
                'last_login' => '2025-06-24 07:52:00',
                'first_name' => 'Rahmania Nanda',
                'last_name' => 'Febriyanti, A.Md.Bns',
                'created_at' => '2025-04-08 09:06:00',
                'updated_at' => '2025-06-24 07:52:00',
                'deleted_at' => null,
                'manager_id' => 2,
                'employee_num' => '0896.08.12.2022',
                'username' => '0896.08.12.2022',
                'notes' => null,
                'company_id' => 1,
                'remember_token' => null,
                'role_id' => 3, // pic_unit
            ],
            [
                'id' => 4,
                'email' => 'pelaksana@rumahsakitfathmamedika.com',
                'password' => Hash::make('pelaksana123'),
                'activated' => 1,
                'created_by' => 1,
                'activated_at' => '2025-06-24 09:00:00',
                'last_login' => '2025-06-24 09:00:00',
                'first_name' => 'Ahmad',
                'last_name' => 'Teknisi',
                'created_at' => '2025-04-08 09:06:00',
                'updated_at' => '2025-06-24 09:00:00',
                'deleted_at' => null,
                'manager_id' => 3,
                'employee_num' => 'TKS001',
                'username' => 'pelaksana',
                'notes' => 'Teknisi Pelaksana',
                'company_id' => 1,
                'remember_token' => null,
                'role_id' => 2, // pelaksana
            ],
        ]);
    }
}