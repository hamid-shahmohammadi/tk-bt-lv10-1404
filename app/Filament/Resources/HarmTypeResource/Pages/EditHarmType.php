<?php

namespace App\Filament\Resources\HarmTypeResource\Pages;

use App\Filament\Resources\HarmTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHarmType extends EditRecord
{
    protected static string $resource = HarmTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
