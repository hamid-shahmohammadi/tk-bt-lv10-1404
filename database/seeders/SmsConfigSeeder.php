<?php

namespace Database\Seeders;

use App\Models\SmsConfig;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SmsConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SmsConfig::insert([
            'username'=>'takayar',
            'password'=>'6616036',
            'url'=>'http://api',
            'happy_birthday'=>true,
            'happy_birthday_massage'=>'happy birthday',
            'from'=>'300020020',
        ]);
    }
}
