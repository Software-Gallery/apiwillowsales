<?php

namespace App\Filament\Resources\TrnSalesOrderDetails\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrnSalesOrderDetailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_sales_order')
                    ->label('Kode Sales Order')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('barang.nama_barang')
                    ->label('Barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('qty_besar')
                    ->label('Qty Besar')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_tengah')
                    ->label('Qty Tengah')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('qty_kecil')
                    ->label('Qty Kecil')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('disc_cash')
                    ->label('Diskon Cash')
                    ->money('IDR'),
                TextColumn::make('disc_perc')
                    ->label('Diskon %')
                    ->suffix('%'),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([

            ])
            ->toolbarActions([
                
            ]);
    }
}
