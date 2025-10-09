<?php

// namespace App\Livewire;

// use Filament\Widgets\ChartWidget;

// class SalesChart extends ChartWidget
// {
//     protected ?string $heading = 'Sales Chart';

//     protected function getData(): array
//     {
//         return [
//             //
//         ];
//     }

//     protected function getType(): string
//     {
//         return 'line';
//     }
// }

// namespace App\Filament\Widgets;
namespace App\Livewire;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesChart extends ChartWidget
{
    protected ?string $heading = 'Penjualan per Bulan';

    protected function getData(): array
    {
        $sales = DB::table('trn_sales_order_header')
            ->selectRaw('DATE_FORMAT(tgl_sales_order, "%b") as bulan, SUM(total) as total')
            ->where('status', '!=', 'DRAFT')
            ->groupBy('bulan')
            ->orderByRaw('MONTH(tgl_sales_order)')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Penjualan',
                    'data' => $sales->pluck('total'),
                    'backgroundColor' => '#f59e0b', // Amber-500
                ],
            ],
            'labels' => $sales->pluck('bulan'),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
