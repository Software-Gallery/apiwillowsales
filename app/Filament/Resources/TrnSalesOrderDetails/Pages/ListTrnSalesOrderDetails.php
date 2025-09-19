<?php

namespace App\Filament\Resources\TrnSalesOrderDetails\Pages;

use App\Filament\Resources\TrnSalesOrderDetails\TrnSalesOrderDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrnSalesOrderDetails extends ListRecords
{
    protected static string $resource = TrnSalesOrderDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
