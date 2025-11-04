<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomersImportTK implements ToModel, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] != "ردیف") {

            if ($row[2] == "اصلی") {
                // dd($row);
                $cus_count = Customer::where('national_code', $row[8])->count();
                if ($cus_count == 0) {
                    return new Customer([
                        'name' => $row[3],
                        'family' => $row[4],
                        'father'=>$row[5],
                        'national_code' => $row[8],
                        'personnel_code' => $row[1],
                        'username' => $row[8],
                        'password' => Hash::make($row[8]),
                        'organization_id' => 2,
                        'contract_id' => 2,
                        'mobile' => $row[13],
                        'user_id' => 2,
                        'active' => 1,
                        'sheba' => $row[14],
                    ]);
                }
            }
        }
    }
    public function rules(): array
    {
        return [
            '*.national_code' => ['unique:customers,national_code']
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.national_code.unique' => 'کد ملی تکراری می باشد',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        Log::error($failures);
    }
    public function onError(\Throwable $e)
    {
        Log::error($e);
    }
}
