<?php

namespace App\Filament\Resources\TrnSalesOrderHeaders\Pages;

use App\Filament\Resources\TrnSalesOrderHeaders\TrnSalesOrderHeaderResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrnSalesOrderHeader extends ViewRecord
{
    protected static string $resource = TrnSalesOrderHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
