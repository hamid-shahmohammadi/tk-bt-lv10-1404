<?php

namespace App\Tables\Columns;

use Filament\Tables\Columns\Column;

class SickColumn extends Column
{
    protected string $view = 'tables.columns.sick-column';
    public $sick;
    public function mount(){
        $this->sick=$getRecord();
    }
}
