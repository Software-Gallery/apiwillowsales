<?php

namespace App\Filament\Resources\MstBarangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class MstBarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_barang')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('kode_barang')
                    ->label('Kode Barang')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable(),

                TextColumn::make('satuan_besar')
                    ->label('Satuan Besar'),

                TextColumn::make('satuan_tengah')
                    ->label('Satuan Tengah'),

                TextColumn::make('satuan_kecil')
                    ->label('Satuan Kecil'),

                TextColumn::make('konversi_besar')
                    ->label('Konversi Besar')
                    ->formatStateUsing(fn ($state) => number_format($state, 2)),

                TextColumn::make('konversi_tengah')
                    ->label('Konversi Tengah')
                    ->formatStateUsing(fn ($state) => number_format($state, 2)),

                TextColumn::make('harga')
                    ->label('Harga')
                    ->format(fn($value) => number_format($value, 0, ',', '.')),
    
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->circular(),
            ])
            ->defaultSort('kode_barang')
            ->filters([
                //
            ])
            ->recordActions([

            ])
            ->toolbarActions([
                
            ]);
    }
}
