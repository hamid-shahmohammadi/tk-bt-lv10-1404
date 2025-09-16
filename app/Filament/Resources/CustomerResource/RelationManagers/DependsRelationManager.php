<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Models\Relation;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\CreateAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class DependsRelationManager extends RelationManager
{
    protected static string $relationship = 'depends';
    protected static ?string $label = 'افراد تحت تکفل';
    protected static ?string $pluralLabel = 'افراد تحت تکفل';
    protected static ?string $title = 'افراد تحت تکفل';



    public function form(Form $form): Form
    {

        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(64),
                TextInput::make('family')
                    ->required()
                    ->maxLength(64),
                TextInput::make('father')
                    ->required()
                    ->maxLength(32),
                Select::make('sex')->label('جنسیت')
                    ->options([
                        'm' => 'مرد',
                        'f' => 'زن'
                    ]),
                TextInput::make('national_code')->required()->label('کدملی'),
                TextInput::make('birth_certificate')->label('شماره شناسنامه'),
                DatePicker::make('birth_date')->jalali()
                    ->label('تاریخ تولد'),
                TextInput::make('mobile')->label('موبایل'),
                Section::make()
                    ->schema([
                        TextInput::make('phone')->label('تلفن'),
                        Checkbox::make('active')->label('وضعیت')
                    ])->columns(1),
                Select::make('relation_id')->label('نسبت')
                    ->options(Relation::all()->pluck('name', 'id'))
                    ->searchable(),
            ]);
    }

    public function table(Table $table): Table
    {

        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')->searchable()->label('نام'),
                TextColumn::make('family')->searchable()->label('نام خانوادگی'),
                TextColumn::make('national_code')->searchable()->label('کدملی'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
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
