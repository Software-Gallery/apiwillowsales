<?php

// namespace App\Livewire;

// use Filament\Widgets\StatsOverviewWidget;
// use Filament\Widgets\StatsOverviewWidget\Stat;

// class SalesStats extends StatsOverviewWidget
// {
//     protected function getStats(): array
//     {
//         return [
//             //
//         ];
//     }
// }

// namespace App\Filament\Widgets;
namespace App\Livewire;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class SalesStats extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSales = DB::table('trn_sales_order_header')
            ->where('status', '!=', 'DRAFT')
            ->sum('total');

        $transactionCount = DB::table('trn_sales_order_header')
            ->where('status', '!=', 'DRAFT')
            ->count();

        $totalQty = DB::table('trn_sales_order_detail')
            ->selectRaw('SUM(qty_besar + qty_tengah + qty_kecil) as total')->value('total');

        return [
            Stat::make('Total Penjualan', 'Rp ' . number_format($totalSales, 0, ',', '.'))
                ->description('Penjualan final')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Jumlah Transaksi', number_format($transactionCount))
                ->description('SO non-DRAFT')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('primary'),

            Stat::make('Qty Produk Terjual', number_format($totalQty))
                ->description('Dari semua ukuran')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),
        ];
    }
}
