<?php

namespace Database\Seeders;

use App\Models\Courier;
use Illuminate\Database\Seeder;

class CouriersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Courier::create(['code' => 'jne','title' => 'JNE']);
        Courier::create(['code' => 'pos','title' => 'POS']);
        Courier::create(['code' => 'tiki','title' => 'TIKI']);
    }
}
