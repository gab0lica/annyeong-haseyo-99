<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //dari template
        // \App\Models\User::factory(10)->create();
        // $this->call([
        //     UserSeeder::class
        // ]);

        // $this->call(LocationsSeeder::class);//RAJAONGKIR
        $this->call(CouriersSeeder::class);//RAJAONGKIR
    }
}
