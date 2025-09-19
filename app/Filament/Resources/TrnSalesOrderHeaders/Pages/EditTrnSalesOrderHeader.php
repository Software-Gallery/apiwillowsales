<?php

namespace App\Filament\Resources\TrnSalesOrderHeaders\Pages;

use App\Filament\Resources\TrnSalesOrderHeaders\TrnSalesOrderHeaderResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTrnSalesOrderHeader extends EditRecord
{
    protected static string $resource = TrnSalesOrderHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
