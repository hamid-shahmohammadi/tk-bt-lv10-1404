<?php

namespace App\Imports;

use App\Models\Depend;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class DependsImport implements ToModel,WithHeadingRow,SkipsOnError,WithValidation,SkipsOnFailure
{
    use Importable,SkipsErrors,SkipsFailures;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $c = Customer::where('national_code', $row['parent'])->first();
        if (isset($c)) {
            return new Depend([
                'name' => $row['name'],
                'family' => $row['family'],
                'father' => $row['father'],
                'sex' => $row['sex'],
                'national_code' => $row['national_code'],
                'birth_date' => $row['birth_date'],
                'organization_id' => $row['organization_id'],
                'mobile' => $row['mobile'],
                'user_id' => $row['user_id'],
                'customer_id' => $c->id,
                'relation_id' => $row['relation_id'],
                'active' => $row['active'],
            ]);
        }
    }

    public function rules():array
    {
        return [
            '*.national_code'=>['unique:depends,national_code'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.national_code.unique' => 'کد ملی تکراری می باشد',

        ];
    }
}
