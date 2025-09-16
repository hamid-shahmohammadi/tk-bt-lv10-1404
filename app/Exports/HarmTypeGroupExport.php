<?php

namespace App\Exports;

use App\Models\Harm;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class HarmTypeGroupExport implements FromCollection,WithHeadings
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
        return DB::table('harms')->select('harm_types.name as ht_name',
        DB::raw("SUM(harms.cost_submit) as harm_cost_submit_sum"),
        DB::raw("count(harms.id) as harm_cont"),
        )
        ->leftJoin('harm_types',function($join){
            $join->on('harm_types.id','harms.harm_type_id');
        })
        ->where(DB::raw('UNIX_TIMESTAMP(harms.created_at)'),'>=',$this->sd)
        ->where(DB::raw('UNIX_TIMESTAMP(harms.created_at)'),'<=',$this->ed)
        ->groupBy('ht_name')
        ->get();
    }

    public function headings(): array
    {
        return [
            'نام تعهد',
            'جمع مبلغ',
            'تعداد نسخ',

        ];
    }
}
