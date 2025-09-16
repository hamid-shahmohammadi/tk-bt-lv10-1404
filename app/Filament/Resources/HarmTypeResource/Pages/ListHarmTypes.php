<?php

namespace App\Filament\Resources\HarmTypeResource\Pages;

use App\Filament\Resources\HarmTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHarmTypes extends ListRecords
{
    protected static string $resource = HarmTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
