<?php

namespace App\Filament\Customer\Resources\HarmResource\Pages;

use App\Filament\Customer\Resources\HarmResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHarm extends EditRecord
{
    protected static string $resource = HarmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
