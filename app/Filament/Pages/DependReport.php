<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Organization;
use App\Exports\DependsExport;
use Livewire\Attributes\Computed;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class DependReport extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.depend-report';

    protected static ?string $title = 'گزارش تحت تکفل یک سازمان';
    protected static ?string $breadcrumb = 'گزارش تحت تکفل یک سازمان';
    protected static ?string $navigationGroup = 'گزارشات';
    protected static ?int $navigationSort = 21;

    public $org;

    #[Computed]
    public function getOrg(){
        return Organization::all();
    }

    public function report(){
        return (new DependsExport($this->org))->download('depend.xlsx');
    }
}
