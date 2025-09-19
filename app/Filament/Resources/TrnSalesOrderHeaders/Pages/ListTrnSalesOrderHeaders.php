<?php

namespace App\Filament\Resources\TrnSalesOrderHeaders\Pages;

use App\Filament\Resources\TrnSalesOrderHeaders\TrnSalesOrderHeaderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrnSalesOrderHeaders extends ListRecords
{
    protected static string $resource = TrnSalesOrderHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
