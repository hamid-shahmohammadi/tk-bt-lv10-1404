<?php

namespace App\Imports;

use App\Models\Depend;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;

class DependsTKImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] != "ردیف") {

            if ($row[2] != "اصلی") {
                if($row[2]=="همسر"){
                    $rel=1;
                    $sex="f";
                }elseif($row[2]=="دختر"){
                    $rel=3;
                     $sex="f";
                }
                elseif($row[2]=="پسر"){
                    $rel=2;
                     $sex="m";
                }elseif($row[2]=="مادر"){
                    $rel=5;
                     $sex="f";
                }elseif($row[2]=="پدر"){
                    $rel=4;
                    $sex="m";
                }
                // dd($row);
                $c = Customer::where('national_code', $row[8])->first();
                if (isset($c)) {
                    // dd($row[9]);
                    return new Depend([
                        'name' => $row[3],
                        'family' => $row[4],
                        'father' => $row[5],
                        'sex' => $sex,
                        'national_code' => $row[9],
                        'birth_date' => $row[6],
                        'organization_id' => 2,
                        'mobile' => '',
                        'user_id' => 2,
                        'customer_id' => $c->id,
                        'relation_id' => $rel,
                        'active' => 1,
                    ]);
                }
            }
        }
    }
}
