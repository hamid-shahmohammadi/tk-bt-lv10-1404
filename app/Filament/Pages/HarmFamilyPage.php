<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Exports\HarmFamilyExport;
use Morilog\Jalali\CalendarUtils;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class HarmFamilyPage extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.harm-family-page';
    protected static ?string $title = 'گزارش خسارات خانوادگی';
    protected static ?string $breadcrumb = 'گزارش خسارات خانوادگی';
    protected static ?string $navigationGroup = 'گزارشات';
    protected static ?int $navigationSort = 24;

    public $start_date = null;
    public $end_date = null;
    public $national_code = null;
    
    public function search()
    {
        if($this->start_date && $this->end_date){
            $s_date=explode("/",$this->start_date);
            $e_date=explode("/",$this->end_date);
            $s_g=CalendarUtils::toGregorian($s_date[0],$s_date[1],$s_date[2]);
            $e_g=CalendarUtils::toGregorian($e_date[0],$e_date[1],$e_date[2]);
            $s_time=strtotime(implode('-',$s_g));
            $e_time=strtotime(implode('-',$e_g));

            return (new HarmFamilyExport($this->national_code,$s_time,$e_time))->download('harms.xlsx');
        }
    }
}
