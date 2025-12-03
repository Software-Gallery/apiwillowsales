<?php

namespace App\Filament\Resources\Logins\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use App\Http\Controllers\Api\LoginController;
use Filament\Notifications\Notification;

class LoginsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('name')
                    ->label('Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('reset_imei')
                    ->label('Reset IMEI')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning') 
                    ->action(function ($record) {
                        // Panggil fungsi resetImei dengan ID record
                        (new LoginController())->resetImei($record->id);
                        Notification::make()
                            ->title('IMEI berhasil direset!')
                            ->success()
                            ->send();
                    }),                
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
