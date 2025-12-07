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
        // dd($row);
        if ($row[0] != "ردیف بیمه شده") {
            // dd($row);
            if (isset($row[12]) && $row[12] != 1) {
                // dd($row);
                $cus = Customer::where('national_code', $row[13])->first();
                if ($cus) {
                    // dd($row);
                    if ($row[12] == 2) {
                        $rel = 1;
                        $sex = "f";
                    } elseif ($row[12] == 8) {
                        $rel = 3;
                        $sex = "f";
                    } elseif ($row[12] == 7) {
                        $rel = 2;
                        $sex = "m";
                    } elseif ($row[12] == 4) {
                        $rel = 5;
                        $sex = "f";
                    } elseif ($row[12] == 3) {
                        $rel = 4;
                        $sex = "m";
                    }

                    return new Depend([
                        'name' => $row[2],
                        'family' => $row[3],
                        'father' => $row[4],
                        'sex' => $sex,
                        'national_code' => $row[8],
                        'birth_date' => $row[5]??'',
                        'organization_id' => 3,
                        'mobile' => '',
                        'user_id' => 2,
                        'customer_id' => $cus->id,
                        'relation_id' => $rel,
                        'active' => 1,
                    ]);

                }
            }
        }
    }
}
