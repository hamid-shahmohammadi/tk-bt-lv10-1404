<?php

namespace App\Exports;

use App\Models\Harm;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class HarmsOrgGroupExport implements FromCollection,WithHeadings
{
    use Exportable;
    protected $sd,$ed;

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
        return DB::table('harms')->select('organizations.name as org_name',
        DB::raw("SUM(harms.cost_submit) as harm_cost_submit_sum"),
        DB::raw("count(harms.id) as harm_cont"),
        )
        ->leftJoin('customers',function($join){
            $join->on('customers.id','harms.customer_id');
        })
        ->leftJoin('organizations',function($join){
            $join->on('organizations.id','customers.organization_id');
        })
        ->where(DB::raw('UNIX_TIMESTAMP(harms.created_at)'),'>=',$this->sd)
        ->where(DB::raw('UNIX_TIMESTAMP(harms.created_at)'),'<=',$this->ed)
        ->groupBy('organizations.id')
        ->get();
    }

    public function headings(): array
    {
        return [
            'نام شرکت',
            'جمع مبلغ',
            'تعداد نسخ',

        ];
    }
}
