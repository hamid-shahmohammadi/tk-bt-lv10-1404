<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contracts')->insert([
            [
                'name'=>'طرح 2',
                'active'=>1,
                'create_date'=>'2024-01-21',
                'end_date'=>'2025-01-21',
            ],
            [
                'name'=>'طرح 3',
                'active'=>1,
                'create_date'=>'2024-01-21',
                'end_date'=>'2026-01-21',
            ],
        ]);
        DB::table('contract_details')->insert([
            [
                'contract_id'=>1,
                'harm_type_id'=>1,
                'cost'=>'200000',
                'repeat'=>0,
            ],
        ]);
    }
}
