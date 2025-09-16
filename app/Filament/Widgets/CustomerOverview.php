<?php

namespace App\Filament\Widgets;

use App\Models\Harm;
use App\Models\Depend;
use App\Models\Customer;
use App\Models\Organization;
use Morilog\Jalali\Jalalian;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class CustomerOverview extends BaseWidget
{
    protected static ?int $sort = 0;
    protected function getStats(): array
    {
        $date = Jalalian::now(); 
        $mon_day=$date->getMonth().'/'.$date->getDay();
        $bd_num=Customer::where('birth_date','like','%'.$mon_day.'%')->count();
        return [
            Stat::make('تعداد بیمه شدگان اصلی', Customer::count()),
            Stat::make('تعداد افراد تحت تکفل', Depend::count()),
            Stat::make('تعداد کل بیمه شدگان', Depend::count()+Customer::count()),
            Stat::make('تعداد خسارات', Harm::count()),
            Stat::make('بیمه شده اصلی امروز، سالروز تولدشان است', $bd_num),
            Stat::make('تعداد سازمانها', Organization::count()),
        ];
    }
}
