<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Support\Enums\Icon;
use App\Livewire\SalesStats;
use App\Livewire\SalesChart;

class SalesDashboard extends Page
{
    // protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    // protected static Icon | string | null $navigationIcon = Icon::ChartBar;

    // protected string $view = 'filament.pages.sales-dashboard';

// app/Filament/Pages/Dashboard.php

public function getHeaderWidgets(): array
{
    return [
        SalesStats::class,
        SalesChart::class,
    ];
}

public function getWidgets(): array
{
    return [
        SalesChart::class,
        SalesStats::class,
    ];
}

}
