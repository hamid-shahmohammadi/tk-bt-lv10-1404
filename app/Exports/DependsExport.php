<?php

namespace App\Exports;

use App\Models\Depend;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class DependsExport implements WithMapping,WithHeadings,FromCollection
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
    public function collection()
    {

        return DB::table('depends')
            ->leftJoin('customers','customers.id','=','depends.customer_id')
            ->where('customers.organization_id',$this->org_id)
            ->select('depends.*', 'customers.name as cus_name', 'customers.family as cus_family')
            ->get();

    }

    public function map($depend): array
    {
        return [
            $depend->id,
            $depend->name.' '.$depend->family,
            $depend->national_code,
            $depend->birth_date,
            $depend->mobile,
            $depend->cus_name.' '.$depend->cus_family,
            $depend->start_activity,
            $depend->end_activity,
            $depend->active == 1 ? 'فعال' : 'غیر فعال',

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
            'نام و نام خانوادگی بیمه شده اصلی',
            'تاریخ شروع فعالیت',
            'تاریخ پایان فعالیت',
            'فعال',
        ];
    }
}
