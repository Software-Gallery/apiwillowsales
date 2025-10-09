<?php

namespace App\Filament\Resources\TrnSalesOrderHeaders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrnSalesOrderHeadersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_sales_order')
                    ->label('Kode Sales Order')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tgl_sales_order')
                    ->label('Tanggal Sales Order')
                    ->date()
                    ->sortable(),
                TextColumn::make('departemen.nama_departemen')
                    ->label('Departemen')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('customer.nama_customer')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('karyawan.nama')
                    ->label('Karyawan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('no_ref')
                    ->label('No Referensi')
                    ->searchable(),
                TextColumn::make('tgl_ref')
                    ->label('Tanggal Referensi')
                    ->date(),
                TextColumn::make('total')
                    ->label('Total')
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
