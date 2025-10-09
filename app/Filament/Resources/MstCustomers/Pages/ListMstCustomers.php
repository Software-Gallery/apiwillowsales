<?php

namespace App\Filament\Resources\MstCustomers\Pages;

use App\Filament\Resources\MstCustomers\MstCustomerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstCustomers extends ListRecords
{
    protected static string $resource = MstCustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
