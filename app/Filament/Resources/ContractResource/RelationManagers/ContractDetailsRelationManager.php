<?php

namespace App\Filament\Resources\ContractResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Contract;
use App\Models\HarmType;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class ContractDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'contract_details';
    protected static ?string $label = 'جزئیات قرارداد';

    protected static ?string $title = 'جزئیات قرارداد';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('cost')
                ->currencyMask(thousandSeparator: ',')
                    ->label('سقف هزینه')
                    ->required()
                    ,
                TextInput::make('repeat')->numeric()->label('سقف دفعات'),

                // Select::make('contract_id')->label('قرارداد')
                //     ->required()
                //     ->options(Contract::all()->pluck('name', 'id'))
                //     ->searchable(),
                Select::make('harm_type_id')->label('نوع خسارت')
                    ->required()
                    ->options(HarmType::all()->pluck('name', 'id'))
                    ->searchable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('cost')
            ->columns([
                TextColumn::make('cost')->label('سقف هزینه')->formatStateUsing(fn (string $state): string => number_format($state)),
                TextColumn::make('contract.name')->label('نام قرارداد'),
                TextColumn::make('harmtype.name')->label('نوع خسارت'),
                TextColumn::make('repeat')->label('سقف دفعات'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['contract_id'] = $this->ownerRecord->id;
                    return $data;
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
