<?php

namespace App\Filament\Resources\MstProvinsis\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MstProvinsisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_provinsi')
                    ->label('ID Provinsi')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kode_provinsi')
                    ->label('Kode Provinsi')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                
            ]);
    }
}
