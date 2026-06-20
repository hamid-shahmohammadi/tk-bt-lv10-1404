<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        foreach (range(1, 10) as $index) {
            DB::table('customers')->insert([
                'name' => $faker->firstName,
                'family' => $faker->lastName,
                'email' => $faker->email,
                'username' => random_int(1000000000, 9999999999),
                'national_code' => random_int(1000000000, 9999999999),
                'password' => Hash::make('password'),
                'organization_id'=>random_int(1, 2),
                'active' => true
            ]);
        }
        foreach (range(1, 10) as $index) {
            DB::table('depends')->insert([
                'name' => $faker->firstName,
                'family' => $faker->lastName,
                'national_code' => random_int(1000000000, 9999999999),
                'active' => true,
                'sex' => 'm',
                'birth_date' => '1361/1/1',
                'customer_id' => 1,
            ]);
        }
    }
}
