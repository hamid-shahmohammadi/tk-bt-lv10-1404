<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomersExport implements FromQuery
{
    use Exportable;
    protected $org_id;

    public function __construct($org_id)
    {
        $this->org_id = $org_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {

        return Customer::query()->where('organization_id',$this->org_id);
    }

    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->name.' '.$customer->family,
            $customer->national_code,
            $customer->birth_date,
            $customer->mobile,
            $customer->start_activity,
            $customer->end_activity,
            $customer->active == 1 ? 'فعال' : 'غیر فعال',
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'نام و نام خانوادگی',
            'کدملی',
            'تاریخ تولد',
            'شماره همراه',
            'تاریخ شروع فعالیت',
            'تاریخ پایان فعالیت',
            'فعال',
        ];
    }
}
