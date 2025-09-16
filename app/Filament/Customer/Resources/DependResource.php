<?php

namespace App\Filament\Customer\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Depend;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Customer\Resources\DependResource\Pages;
use App\Filament\Customer\Resources\DependResource\RelationManagers;

class DependResource extends Resource
{
    protected static ?string $model = Depend::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel = 'افراد تحت تکفل';
    protected static ?string $breadcrumb = 'افراد تحت تکفل';
    protected static ?string $pluralModelLabel = 'افراد تحت تکفل';

    protected static ?string $navigationGroup = 'اطلاعات بیمه شده';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('NameFamily')->label('نام ونام خانوادگی')
                ->view('tables.columns.depend-name-column'),
                TextColumn::make('national_code')->label('کدملی'),
                TextColumn::make('birth_date')->label('تاریخ تولد'),

                TextColumn::make('father')->label('نام پدر'),
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
            'index' => Pages\ListDepends::route('/'),
            // 'create' => Pages\CreateDepend::route('/create'),
            // 'edit' => Pages\EditDepend::route('/{record}/edit'),
        ];
    }
    public static function canCreate(): bool
   {
      return false;
   }
}
