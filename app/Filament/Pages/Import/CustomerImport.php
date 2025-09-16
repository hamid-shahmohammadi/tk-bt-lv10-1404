<?php

namespace App\Filament\Pages\Import;

use Filament\Pages\Page;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use App\Imports\CustomerImport as CusImport;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class CustomerImport extends Page
{
    use WithFileUploads, HasPageShield;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.import.customer-import';
    protected static ?string $title = 'وارد کردن بیمه شدگان اصلی';
    protected static ?string $breadcrumb = 'وارد کردن بیمه شدگان اصلی';
    protected static ?string $navigationGroup = 'ورود اطلاعات';
    protected static ?int $navigationSort = 10;

    #[Validate('required|mimes:xlsx')]
    public $customerFile;

    public $alert;

    public function save()
    {
        $import=new CusImport();
        $import->import($this->customerFile);
        if($import->failures()->isNotEmpty()){
            $this->alert="آپلود اطلاعات با مشکل مواجه شد";
        }else{
            $this->alert="آپلود اطلاعات با موفقیت انجام شد";
        }
    }
    public function sampleDownload (){
        return Storage::download('/public/temp/import_Customer.xlsx');;
    }
}
