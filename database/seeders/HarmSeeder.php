<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 10) as $index) {
            DB::table('harms')->insert([
                [
                    'billing_date' => '1402/11/08',
                    'billing_time' => 1706400000,
                    'description' => 'desc',
                    'cost' => random_int(1000000, 9000000),
                    'cost_submit' => random_int(100000, 900000),
                    'harm_type_id' => 1,
                    'user_id' => 1,
                    'payment_status_id' => random_int(1, 2),
                    'customer_id' => $index,
                    'depend_id' => null,
                    'contract_id' => 1,
                ],
            ]);
        }
    }
}
