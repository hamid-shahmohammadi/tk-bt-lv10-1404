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
        // dd($row);
        if ($row[0] != "ردیف بیمه شده") {
            // dd($row);
            if (isset($row[12]) && $row[12] == 1) {                
                $cus_count = Customer::where('national_code', $row[8])->count();
                if ($cus_count == 0) {
                    // dd($row);
                    return new Customer([
                        'name' => $row[2],
                        'family' => $row[3],
                        'father'=>$row[4],
                        'national_code' => $row[8],
                        'personnel_code' => $row[1],
                        'username' => $row[8],
                        'password' => Hash::make($row[8]),
                        'organization_id' => 3,
                        'contract_id' => 3,
                        'mobile' => $row[11],
                        'user_id' => 2,
                        'active' => 1,
                        'sheba' => $row[21],
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
