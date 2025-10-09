<?php

namespace App\Filament\Resources\MstKaryawans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstKaryawansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_karyawan')
                    ->label('ID Karyawan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kode_karyawan')
                    ->label('Kode Karyawan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama Karyawan')
                    ->sortable()
                    ->searchable(),
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
