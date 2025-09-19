<?php

namespace App\Filament\Resources\MstCustomers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;

class MstCustomersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_customer')
                ->label('ID')
                ->sortable()
                ->searchable(),
        
                TextColumn::make('kode_customer')
                    ->label('Kode Customer')
                    ->sortable()
                    ->searchable(),
            
                TextColumn::make('id_departemen')
                    ->label('Departemen')
                    ->sortable(),
            
                TextColumn::make('nama')
                    ->label('Nama')
                    ->sortable()
                    ->searchable(),
            
                TextColumn::make('alamat')
                    ->label('Alamat')
                    ->limit(50)
                    ->wrap(),
            
                TextColumn::make('id_provinsi')
                    ->label('Provinsi'),
            
                TextColumn::make('id_kota')
                    ->label('Kota'),
            
                TextColumn::make('id_kecamatan')
                    ->label('Kecamatan'),
            
                TextColumn::make('id_kelurahan')
                    ->label('Kelurahan'),
            
                TextColumn::make('kode_pos')
                    ->label('Kode Pos'),
            
                TextColumn::make('latitude')
                    ->label('Latitude'),
            
                TextColumn::make('longitude')
                    ->label('Longitude'),
            
                BooleanColumn::make('is_aktif')
                    ->label('Aktif')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->datetime(),
            
                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->datetime(),
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
