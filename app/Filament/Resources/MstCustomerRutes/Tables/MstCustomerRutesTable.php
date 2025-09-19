<?php

namespace App\Filament\Resources\MstCustomerRutes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Table;

class MstCustomerRutesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
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
                CheckboxColumn::make('day1')->label('Senin'),
                CheckboxColumn::make('day2')->label('Selasa'),
                CheckboxColumn::make('day3')->label('Rabu'),
                CheckboxColumn::make('day4')->label('Kamis'),
                CheckboxColumn::make('day5')->label('Jumat'),
                CheckboxColumn::make('day6')->label('Sabtu'),
                CheckboxColumn::make('day7')->label('Minggu'),
                CheckboxColumn::make('week1')->label('Minggu 1'),
                CheckboxColumn::make('week2')->label('Minggu 2'),
                CheckboxColumn::make('week3')->label('Minggu 3'),
                CheckboxColumn::make('week4')->label('Minggu 4'),
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
