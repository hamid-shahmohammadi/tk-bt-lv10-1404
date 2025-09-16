<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaymentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_statuses')->insert([
            [
                'name'=>'پرداخت نشده',
                'active'=>1,

            ],
            [
                'name'=>'پرداخت شده',
                'active'=>1,

            ],
        ]);
    }
}
