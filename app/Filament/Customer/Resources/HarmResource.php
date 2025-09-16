<?php

namespace App\Filament\Customer\Resources;

use App\Filament\Customer\Resources\HarmResource\Pages;
use App\Filament\Customer\Resources\HarmResource\RelationManagers;
use App\Models\Harm;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\ViewColumn;

class HarmResource extends Resource
{
    protected static ?string $model = Harm::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'خسارت';
    protected static ?string $breadcrumb = 'خسارات';
    protected static ?string $pluralModelLabel = 'خسارات';

    protected static ?string $navigationGroup = 'اطلاعات بیمه شده';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('Sick')->label('نام بیمار')
                ->view('tables.columns.sick-column'),
                TextColumn::make('cost')->label('هزینه'),
                TextColumn::make('cost_submit')->label('هزینه تایید شده'),
                TextColumn::make('billing_date')->label('تاریخ صورت حساب'),
                ViewColumn::make('HarmType')->label('نوع خسارت')
                ->view('tables.columns.harm-type-column'),

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListHarms::route('/'),
            'create' => Pages\CreateHarm::route('/create'),
            'edit' => Pages\EditHarm::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return static::getModel()::query()->where('customer_id',Auth::id());
    }

    public static function canCreate(): bool
   {
      return false;
   }


}
