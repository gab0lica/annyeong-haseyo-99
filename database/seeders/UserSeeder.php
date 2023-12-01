<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //tambah user otomatis
        // DB::table('users')->insert([
        //     'id' => 1,
        //     'username' => 'admin_softui',
        //     'email' => 'admin@softui.com',
        //     'password' => Hash::make('secret'),
        //     'nama' => 'Super Admin',
        //     'role' => 0,
        //     'status' => 1,
        //     'nomor_telepon' => '082315438746'
        //     // 'created_at' => now(),
        //     // 'updated_at' => now()
        // ]);
    }
}
