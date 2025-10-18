<?php

namespace App\Filament\Resources\TrnAbsens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;


class TrnAbsensTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->columns([
                TextColumn::make('kode_sales_order')
                    ->label('Kode Sales Order'),
                ImageColumn::make('kode_sales_order')
                    ->label('Gambar')
                    ->getStateUsing(function ($record) {
                        return Storage::url('/absen' . $record->kode_sales_order);
                    })
                    ->width(100) 
                    ->height(100),                     
                TextColumn::make('id_karyawan')
                    ->label('ID Karyawan'),
                TextColumn::make('id_customer')
                    ->label('ID Customer'),
                TextColumn::make('id_departemen')
                    ->label('ID Departemen'),
                TextColumn::make('tgl')
                    ->label('Tanggal'),
                TextColumn::make('jam_masuk')
                    ->label('Jam Masuk'),
                TextColumn::make('jam_keluar')
                    ->label('Jam Keluar'),
                TextColumn::make('latitude')
                    ->label('Latitude'),
                TextColumn::make('longitude')
                    ->label('Longitude'),
                TextColumn::make('keterangan')
                    ->label('Keterangan'),
                TextColumn::make('alamat')
                    ->label('Alamat'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
