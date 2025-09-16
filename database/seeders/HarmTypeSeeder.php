<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HarmTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('harm_types')->insert([
            [
                'name'=>'دارو',
                'active'=>1,

            ],
            [
                'name'=>'بیمارستانی',
                'active'=>1,

            ],
        ]);
    }
}
