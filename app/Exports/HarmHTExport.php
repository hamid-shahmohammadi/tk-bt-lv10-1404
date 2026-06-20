<?php

namespace App\Exports;

use App\Models\Harm;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class HarmHTExport implements WithMapping,WithHeadings,FromCollection
{
    use Exportable;
    protected $ht_id;

    public function __construct($ht_id)
    {
        $this->ht_id = $ht_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DB::table('harms')
            ->leftJoin('customers','customers.id','=','harms.customer_id')
            ->leftJoin('depends','depends.id','=','harms.depend_id')
            ->where('harms.harm_type_id',$this->ht_id)            
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
