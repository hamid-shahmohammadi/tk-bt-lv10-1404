<?php

namespace App\Filament\Pages;

use App\Models\Customer;
use Filament\Pages\Page;
use App\Models\Organization;
use App\Exports\CustomersExport;
use Livewire\Attributes\Computed;
use Maatwebsite\Excel\Facades\Excel;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class CustomerReport extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.customer-report';

    protected static ?string $title = 'گزارش بیمه شدگان یک سازمان';
    protected static ?string $breadcrumb = 'گزارش بیمه شدگان یک سازمان';
    protected static ?string $navigationGroup = 'گزارشات';
    protected static ?int $navigationSort = 20;

    public $org;

    #[Computed]
    public function getOrg(){
        return Organization::all();
    }

    public function report(){
        return (new CustomersExport($this->org))->download('customer.xlsx');
    }
}
