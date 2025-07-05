<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'admin', 'display_name' => 'Admin'],
            ['name' => 'pic_unit', 'display_name' => 'PIC Unit'],
            ['name' => 'pelaksana', 'display_name' => 'Pelaksana'],
            ['name' => 'manager_it', 'display_name' => 'Manager IT'],
        ]);
    }
}