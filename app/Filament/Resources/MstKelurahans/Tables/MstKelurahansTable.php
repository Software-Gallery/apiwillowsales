<?php

namespace App\Filament\Resources\MstKelurahans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MstKelurahansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_kelurahan')
                    ->label('ID Kelurahan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kode_kelurahan')
                    ->label('Kode Kelurahan')
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
