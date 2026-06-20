<?php

namespace App\Filament\Customer\Resources\DependResource\Pages;

use App\Filament\Customer\Resources\DependResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepend extends EditRecord
{
    protected static string $resource = DependResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
