<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Board::insert([
            'text'=>'تابلو اعلانات',
            'second'=> '50s',
        ]);
    }
}
