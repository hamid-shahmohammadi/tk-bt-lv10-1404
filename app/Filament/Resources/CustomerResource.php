<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;

use App\Models\Contract;
use App\Models\Customer;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Organization;
use Filament\Resources\Resource;
use Filament\Actions\CreateAction;
use App\Tables\Columns\DependColumn;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use App\Filament\Resources\CustomerResource\Pages\Harm;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\CustomerResource\Pages\HarmImage;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Filament\Resources\CustomerResource\Pages\ViewCustomr;
use App\Filament\Resources\CustomerResource\RelationManagers\DependsRelationManager;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $modelLabel = 'بیمه شده';
    protected static ?string $breadcrumb = 'بیمه شدگان';
    protected static ?string $pluralModelLabel = 'بیمه شدگان';

    protected static ?string $navigationGroup = 'اطلاعات بیمه شدگان';
    protected static ?int $navigationSort = 1;


    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                TextInput::make('name')->required()->label('نام'),
                TextInput::make('family')->required()->label('نام خانوادگی'),
                TextInput::make('father')->label('نام پدر'),
                TextInput::make('email')->label('ایمیل'),
                TextInput::make('username')->required()->label('نام کاربری'),
                TextInput::make('personnel_code')->label('کد پرسنلی'),
                TextInput::make('national_code')->required()->label('کدملی'),
                TextInput::make('birth_certificate')->label('شماره شناسنامه'),
                DatePicker::make('birth_date')->jalali()
                    ->label('تاریخ تولد'),
                Select::make('organization_id')->label('سازمان')
                    ->options(Organization::all()->pluck('name', 'id')),
                Select::make('contract_id')->label('قرارداد')
                    ->options(Contract::all()->pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('password')->required()->label('کلمه عبور')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                TextInput::make('mobile')->label('موبایل'),
                TextInput::make('phone')->label('تلفن'),
                TextInput::make('sheba')->label('شبا'),
                TextInput::make('account_number')->label('شماره حساب'),
                TextInput::make('booklet_number')->label('شماره دفترچه'),
                Select::make('sex')->label('جنسیت')
                    ->options([
                        'm' => 'مرد',
                        'f' => 'زن'
                    ]),
                DatePicker::make('start_activity')->jalali()->label('تاریخ استخدام'),
                DatePicker::make('end_activity')->jalali()->label('تاریخ اتمام'),
                Checkbox::make('active')->label('وضعیت'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->label('نام'),
                TextColumn::make('family')->searchable()->label('نام نام خانوادگی'),
                TextColumn::make('national_code')
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query->with('depends')->where('national_code', 'like', "%{$search}%")
                            ->orWhereHas('depends', function ($q) use ($search) {
                                $q->Where('national_code', 'like', "%{$search}%");
                            });
                    })
                    ->label('کدملی'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('harm')->label('خسارات')
                    ->url(fn (Model $record): string => route('filament.admin.resources.customers.harm', ['record' => $record])),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->exports([
                        ExcelExport::make()->withColumns([
                            Column::make('name'),
                            Column::make('family'),
                            Column::make('national_code'),
                            Column::make('birth_date')
                            ->formatStateUsing(fn ($state) => \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($state))),
                            Column::make('mobile'),
                            Column::make('start_activity')
                            ->formatStateUsing(fn ($state) => \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($state))),
                            Column::make('end_activity')
                            ->formatStateUsing(fn ($state) => \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($state))),
                            Column::make('active')
                            ->formatStateUsing(fn ($state) => $state == 1 ? 'فعال' : 'غیر فعال'),

                        ]),
                    ]),
                ]),
            ]);

    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DependsRelationManager::class,

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'view' => ViewCustomr::route('/{record}'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
            'harm' => Harm::route('/{record}/harm'),
            'attach' => HarmImage::route('/{record}/attach'),
        ];
    }
}
