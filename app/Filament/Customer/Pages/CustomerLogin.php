<?php

namespace App\Filament\Customer\Pages;

use Filament\Pages\Page;
use Filament\Pages\Auth\Login;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Component;

class CustomerLogin extends Login
{
    // protected static ?string $navigationIcon = 'heroicon-o-document-text';

    // protected static string $view = 'filament.customer.pages.customer-login';
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('نام کاربری')
            // ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }
}
