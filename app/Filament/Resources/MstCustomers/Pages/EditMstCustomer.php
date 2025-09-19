<?php

namespace App\Filament\Resources\MstCustomers\Pages;

use App\Filament\Resources\MstCustomers\MstCustomerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMstCustomer extends EditRecord
{
    protected static string $resource = MstCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
