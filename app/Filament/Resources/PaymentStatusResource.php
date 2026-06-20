<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PaymentStatus;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentStatusResource\Pages;
use App\Filament\Resources\PaymentStatusResource\RelationManagers;

class PaymentStatusResource extends Resource
{
    protected static ?string $model = PaymentStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'وضعیت پرداخت';
    protected static ?string $breadcrumb = 'وضعیت پرداخت';
    protected static ?string $pluralModelLabel = 'وضعیت پرداخت';

    protected static ?string $navigationGroup = 'اطلاعات پایه';
    protected static ?int $navigationSort = 8;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')->label('نام'),
                        Checkbox::make('active')->label('وضعیت'),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('وضعیت پرداخت'),
                CheckboxColumn::make('active')->disabled()->label('وضعیت'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentStatuses::route('/'),
            'create' => Pages\CreatePaymentStatus::route('/create'),
            'edit' => Pages\EditPaymentStatus::route('/{record}/edit'),
        ];
    }
}
