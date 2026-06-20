<?php

namespace App\Exports;

use App\Models\Harm;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;

class HarmsExport implements WithMapping,WithHeadings,FromCollection
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
        $hs=DB::table('harms')
            ->leftJoin('customers','customers.id','=','harms.customer_id')
            ->leftJoin('depends','depends.id','=','harms.depend_id')
            ->where('customers.organization_id',$this->org_id)
            ->select('harms.*',
            'customers.name as cus_name', 'customers.family as cus_family',
            'depends.name as dep_name', 'depends.family as dep_family',
            )
            ->get();

        if($hs){
            return $hs;
        }
    }

    public function map($harm): array
    {
        if($harm->depend_id){
            $sick=$harm->dep_name.' '.$harm->dep_family;
        }else{
            $sick=$harm->cus_name.' '.$harm->cus_family;
        }
        return [
            $harm->id,
            $harm->cost,
            $harm->cost_submit,
            $harm->billing_date,
            $sick
        ];
    }

    public function headings(): array
    {
        return [
            'id',
            'هزینه',
            'مبلغ تایید شده',
            'تاریخ صورتحساب',
            'نام بیمار'
        ];
    }
}
