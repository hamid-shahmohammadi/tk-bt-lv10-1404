<?php

namespace App\Filament\Customer\Resources\HarmResource\Pages;

use App\Filament\Customer\Resources\HarmResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHarms extends ListRecords
{
    protected static string $resource = HarmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
