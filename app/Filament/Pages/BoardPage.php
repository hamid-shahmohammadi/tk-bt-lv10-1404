<?php

namespace App\Filament\Pages;

use App\Models\Board;
use Filament\Pages\Page;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class BoardPage extends Page
{
    use HasPageShield;
    
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.board-page';

    protected static ?string $navigationLabel = 'تابلو اعلانات';
    protected static ?string $title = 'تابلو اعلانات';
    protected static ?string $navigationGroup = 'تنظیمات';
    protected static ?int $navigationSort = 28;

    public $text='';
    public $second='';
    public $alert=null;

    public function mount (){
        $board=Board::first();
        $this->text=$board->text;
        $this->second=$board->second;
    }

    public function updateBoard (){
        $board=Board::first();
        $board->text=$this->text;
        $board->second=$this->second;
        $board->save();
        $this->alert="آپدیت تابلو اعلانات با موفقیت انجام شد";
    }

    public function resetAlert (){
        $this->alert=null;
    }

}
