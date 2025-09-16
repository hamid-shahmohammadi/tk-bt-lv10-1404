<?php

namespace App\Filament\Pages\Report;

use Filament\Pages\Page;
use Morilog\Jalali\CalendarUtils;
use App\Exports\HarmTypeGroupExport;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class HarmTypeGroupPage extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.report.harm-type-group-page';
    protected static ?string $title = 'گزارش تعهدات پرداخت';
    protected static ?string $breadcrumb = 'گزارش تعهدات پرداخت';
    protected static ?string $navigationGroup = 'گزارشات';
    protected static ?int $navigationSort = 27;

    public $start_date = null;
    public $end_date = null;

    public function search()
    {
        if($this->start_date && $this->end_date){
            $s_date=explode("/",$this->start_date);
            $e_date=explode("/",$this->end_date);
            $s_g=CalendarUtils::toGregorian($s_date[0],$s_date[1],$s_date[2]);
            $e_g=CalendarUtils::toGregorian($e_date[0],$e_date[1],$e_date[2]);
            $s_time=strtotime(implode('-',$s_g));
            $e_time=strtotime(implode('-',$e_g));

            return (new HarmTypeGroupExport($s_time,$e_time))->download('harms.xlsx');
        }
    }
}
