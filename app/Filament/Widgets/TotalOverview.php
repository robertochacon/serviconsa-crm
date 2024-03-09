<?php

namespace App\Filament\Widgets;

use App\Models\Closing;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class TotalOverview extends BaseWidget
{
    protected function getStats(): array
    {

        $today = number_format(Closing::whereDay('created_at', date('d'))->sum('total_do'), 2);
        $month = number_format(Closing::whereMonth('created_at', date('m'))->sum('total_do'), 2);
        $year = number_format(Closing::whereYear('created_at', date('Y'))->sum('total_do'), 2);

        return [
            Stat::make('Hoy', $today)
            ->description('Total generado hoy')
            ->descriptionIcon('heroicon-m-currency-dollar')
            ->color('info')
            ->chart([1,1]),
            Stat::make('Este mes', $month)
            ->description('Total generado este mes')
            ->descriptionIcon('heroicon-m-currency-dollar')
            ->color('info')
            ->chart([1,1]),
            Stat::make('Año actual', $year)
            ->description('Total generado este año')
            ->descriptionIcon('heroicon-m-currency-dollar')
            ->color('info')
            ->chart([1,1]),
        ];
    }
}
