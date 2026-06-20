<?php

namespace App\Filament\Pages\Report;

use App\Models\HarmType;
use Filament\Pages\Page;
use App\Exports\HarmHTExport;
use Livewire\Attributes\Computed;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class HarmTypePage extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.report.harm-type-page';
    protected static ?string $title = 'گزارش خسارات با نوع خسارت';
    protected static ?string $breadcrumb = 'گزارش خسارات با نوع خسارت';
    protected static ?string $navigationGroup = 'گزارشات';
    protected static ?int $navigationSort = 25;

    public $ht;

    #[Computed]
    public function getHarmTypes(){
        return HarmType::where('active',1)->get();
    }

    public function report (){
        return (new HarmHTExport($this->ht))->download('harms.xlsx');
    }
}
