<?php

namespace App\Filament\Resources\MstSatuans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstSatuansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_satuan')
                    ->label('ID Satuan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kode_satuan')
                    ->label('Kode Satuan')
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
