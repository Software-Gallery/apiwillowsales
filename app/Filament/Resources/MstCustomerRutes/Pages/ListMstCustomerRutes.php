<?php

namespace App\Filament\Resources\MstCustomerRutes\Pages;

use App\Filament\Resources\MstCustomerRutes\MstCustomerRuteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstCustomerRutes extends ListRecords
{
    protected static string $resource = MstCustomerRuteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
