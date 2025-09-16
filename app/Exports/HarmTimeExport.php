<?php

namespace App\Exports;


use App\Models\HarmType;
use Illuminate\Support\Carbon;
use Morilog\Jalali\CalendarUtils;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class HarmTimeExport implements WithMapping,WithHeadings,FromCollection
{
    use Exportable;
    protected $sd,$ed;
    private $row = 1;

    public function __construct($sd,$ed)
    {
        $this->sd = $sd;
        $this->ed = $ed;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // dd($this->sd,$this->ed);
        return DB::table('harms')
            ->leftJoin('customers','customers.id','=','harms.customer_id')
            ->leftJoin('depends','depends.id','=','harms.depend_id')
            ->where(DB::raw('UNIX_TIMESTAMP(harms.created_at)'),'>=',$this->sd)
            ->where(DB::raw('UNIX_TIMESTAMP(harms.created_at)'),'<=',$this->ed)
            ->select('harms.*',
            'customers.name as cus_name', 'customers.family as cus_family',
            'customers.national_code as cus_national_code',
            'customers.sheba as cus_sheba',
            'depends.name as dep_name', 'depends.family as dep_family',
            'depends.national_code as dep_national_code',
            )
            ->get();
    }

    public function map($harm): array
    {

        $harm_type_name=HarmType::find($harm->harm_type_id)->name;
        $customer_name=$harm->cus_name.' '.$harm->cus_family;
        if($harm->depend_id){
            $sick=$harm->dep_name.' '.$harm->dep_family;
            $national_code=$harm->dep_national_code;
        }else{
            $sick=$harm->cus_name.' '.$harm->cus_family;
            $national_code=$harm->cus_national_code;
        }


        $jcreate_date=implode('/',CalendarUtils::toJalali(
        (int)Carbon::parse($harm->created_at)->format('Y'),
        (int)Carbon::parse($harm->created_at)->format('m'),
        (int)Carbon::parse($harm->created_at)->format('d')));


        return [
            $this->row++,
            $harm->id,
            $harm->billing_date,
            $sick,
            $national_code,
            $customer_name,
            $harm->cus_national_code,
            $harm_type_name,
            $harm->cost,
            $harm->cost_submit,
            $harm->cus_sheba,
            $jcreate_date
        ];
    }

    public function headings(): array
    {
        return [
            'ردیف',
            'شماره رسید',
            'تاریخ صورتحساب',
            'نام بیمار',
            'کد ملی بیمار',
            'نام بیمه شده اصلی',
            'کد ملی بیمه شده اصلی',
            'تعهدات قرارداد',
            'هزینه',
            'مبلغ تایید شده',
            'شبا',
            'تاریخ ثبت سیستم',
        ];
    }
}
