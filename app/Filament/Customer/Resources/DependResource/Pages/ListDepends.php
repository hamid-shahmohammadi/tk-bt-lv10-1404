<?php

namespace App\Filament\Customer\Resources\DependResource\Pages;

use App\Filament\Customer\Resources\DependResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepends extends ListRecords
{
    protected static string $resource = DependResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
