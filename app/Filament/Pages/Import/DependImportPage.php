<?php

namespace App\Filament\Pages\Import;

use Filament\Pages\Page;
use App\Imports\DependsImport;
use Illuminate\Support\Facades\Storage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class DependImportPage extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.import.depend-import-page';

    protected static ?string $title = 'وارد کردن افراد تحت تکفل';
    protected static ?string $breadcrumb = 'وارد کردن افراد تحت تکفل';
    protected static ?string $navigationGroup = 'ورود اطلاعات';
    protected static ?int $navigationSort = 11;

    public $dependFile;

    public $alert;

    public function save()
    {
        $import=new DependsImport();
        $import->import($this->dependFile);
        if($import->failures()->isNotEmpty()){
            $this->alert="آپلود اطلاعات با مشکل مواجه شد";
        }else{
            $this->alert="آپلود اطلاعات با موفقیت انجام شد";
        }
    }

    public function sampleDownload (){
        return Storage::download('/public/temp/import_depend.xlsx');;
    }
}
