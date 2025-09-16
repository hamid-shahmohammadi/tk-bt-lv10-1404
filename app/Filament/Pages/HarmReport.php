<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Exports\HarmsExport;
use App\Models\Organization;
use Livewire\Attributes\Computed;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class HarmReport extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.harm-report';

    protected static ?string $title = 'گزارش خسارات یک سازمان';
    protected static ?string $breadcrumb = 'گزارش خسارات یک سازمان';
    protected static ?string $navigationGroup = 'گزارشات';
    protected static ?int $navigationSort = 22;

    public $org;

    #[Computed]
    public function getOrg(){
        return Organization::all();
    }

    public function report(){
        return (new HarmsExport($this->org))->download('harms.xlsx');
    }
}
