<?php

use App\Models\Board;
use App\Livewire\Welcome;
use App\Imports\CustomersImportTK;
use App\Imports\DependsTKImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;

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

Route::get('/import/customer/tk', function () {
   ini_set('max_execution_time', '300');
    Excel::import(new CustomersImportTK, storage_path('/import/cus.xlsx'));
});
Route::get('/import/depend/tk', function () {
   ini_set('max_execution_time', '300');
    Excel::import(new DependsTKImport, storage_path('/import/cus.xlsx'));
});
