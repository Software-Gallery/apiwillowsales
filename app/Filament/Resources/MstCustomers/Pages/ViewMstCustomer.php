<?php

namespace App\Filament\Resources\MstCustomers\Pages;

use App\Filament\Resources\MstCustomers\MstCustomerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMstCustomer extends ViewRecord
{
    protected static string $resource = MstCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
