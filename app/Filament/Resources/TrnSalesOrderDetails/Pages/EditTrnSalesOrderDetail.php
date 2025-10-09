<?php

namespace App\Filament\Resources\TrnSalesOrderDetails\Pages;

use App\Filament\Resources\TrnSalesOrderDetails\TrnSalesOrderDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrnSalesOrderDetail extends EditRecord
{
    protected static string $resource = TrnSalesOrderDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
