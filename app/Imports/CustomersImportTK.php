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

class CustomersImportTK implements ToModel, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (Customer::where('national_code', $row['national_code'])->count() > 0) {
            
            Log::info($row['national_code']);
        } 
        // else {
        //     return new Customer([
        //         'name' => $row['name'],
        //         'family' => $row['family'],
        //         'national_code' => $row['national_code'],
        //         'username' => $row['national_code'],
        //         'password' => Hash::make($row['national_code']),
        //         'organization_id' => 1,
        //         'contract_id' => 1,
        //         'mobile' => $row['mobile'],
        //         'user_id' => 2,
        //         'active' => 1,
        //         'sheba' => $row['sheba'],
        //     ]);
        // }
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
