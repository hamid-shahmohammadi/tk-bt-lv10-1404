<?php

namespace App\Imports;

use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CustomerImport implements ToModel,WithHeadingRow,SkipsOnError,WithValidation,SkipsOnFailure
{
    use Importable,SkipsErrors,SkipsFailures;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            'name'=>$row['name'],
            'family'=>$row['family'],
            'father'=>$row['father'],
            'national_code'=>$row['national_code'],
            'username'=>$row['national_code'],
            'password'=>Hash::make($row['national_code']),
            'birth_date'=>$row['birth_date'],
            'organization_id'=>$row['organization_id'],
            'mobile'=>$row['mobile'],
            'user_id'=>$row['user_id'],
            'active'=>$row['active'],
        ]);
    }

    public function rules():array
    {
        return [
            '*.national_code'=>['unique:customers,national_code']
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.national_code.unique' => 'کد ملی تکراری می باشد',
        ];
    }

}
