<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Contract;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use App\Filament\Resources\ContractResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ContractResource\RelationManagers;
use App\Filament\Resources\ContractResource\RelationManagers\ContractDetailsRelationManager;

class ContractResource extends Resource
{
    protected static ?string $model = Contract::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $modelLabel = 'قرارداد';
    protected static ?string $breadcrumb = 'قراردادها';
    protected static ?string $pluralModelLabel = 'قراردادها';

    protected static ?string $navigationGroup = 'اطلاعات پایه';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('نام قرارداد'),
                        Forms\Components\Checkbox::make('active')->label('وضعیت'),
                    ])->columns(1),
                \Filament\Forms\Components\DatePicker::make('create_date')->jalali()->label('تاریخ شروع'),
                \Filament\Forms\Components\DatePicker::make('end_date')->jalali()->label('تاریخ پایان'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('نام قرارداد')->columnSpan(1),
                CheckboxColumn::make('active')->label('وضعیت'),
                TextColumn::make('create_date')->label('تاریخ شروع')->jalaliDate(),
                TextColumn::make('end_date')->label('تاریخ پایان')->jalaliDate(),
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
            RelationManagers\ContractDetailsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContracts::route('/'),
            'create' => Pages\CreateContract::route('/create'),
            'edit' => Pages\EditContract::route('/{record}/edit'),
        ];
    }
}
