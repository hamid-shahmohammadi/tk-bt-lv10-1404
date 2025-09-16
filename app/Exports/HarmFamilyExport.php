<?php

namespace App\Exports;

use App\Models\Harm;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class HarmFamilyExport implements WithMapping,WithHeadings,FromCollection
{
    use Exportable;

    protected $national_code;
    protected $sd,$ed;
    private $row = 1;

    public function __construct($national_code,$sd,$ed)
    {
        $this->national_code = $national_code;
        $this->sd = $sd;
        $this->ed = $ed;
    }
   
    public function collection()
    {
        return DB::table('harms')
            ->leftJoin('customers','customers.id','=','harms.customer_id')
            ->leftJoin('depends','depends.id','=','harms.depend_id')
            ->where('customers.national_code',$this->national_code)
            ->where(DB::raw('UNIX_TIMESTAMP(harms.created_at)'),'>=',$this->sd)
            ->where(DB::raw('UNIX_TIMESTAMP(harms.created_at)'),'<=',$this->ed)
            ->select('harms.*',
            'customers.name as cus_name', 'customers.family as cus_family',
            'depends.name as dep_name', 'depends.family as dep_family',
            )
            ->get();
    }

    public function map($harm): array
    {
        if($harm->depend_id){
            $sick=$harm->dep_name.' '.$harm->dep_family;
            $sick_type='فرد تحت تکفل';
        }else{
            $sick=$harm->cus_name.' '.$harm->cus_family;
            $sick_type='بیمه شده اصلی';
        }
        return [
            $harm->id,
            $harm->cost,
            $harm->cost_submit,
            $harm->billing_date,
            $sick,
            $sick_type
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'هزینه',
            'مبلغ تایید شده',
            'تاریخ صورتحساب',
            'نام بیمار',
            'نوع بیمار'
        ];
    }
}
