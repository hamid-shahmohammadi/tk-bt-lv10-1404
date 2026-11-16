<?php

use App\Imports\CustomerImport05;
use App\Livewire\Welcome;
use App\Models\Board;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $board=Board::first();
    return view('welcome',compact('board'));
});

Route::get('/import/customer',function(){   
    ini_set('max_execution_time', 300);
    
    Excel::import(new CustomerImport05, storage_path('import/cus.xlsx'));
});
