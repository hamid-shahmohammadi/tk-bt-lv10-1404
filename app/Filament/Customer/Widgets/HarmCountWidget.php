<?php

namespace App\Filament\Customer\Widgets;

use App\Models\Harm;

use App\Models\Depend;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class HarmCountWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make("تعداد خسارات", Harm::where('customer_id',Auth::id())->count()),
            Stat::make("تعداد افراد تحت تکفل", Depend::where('customer_id',Auth::id())->count()),
        ];
    }
}
