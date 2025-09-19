<?php

namespace App\Filament\Resources\MstKotas\Pages;

use App\Filament\Resources\MstKotas\MstKotaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstKotas extends ListRecords
{
    protected static string $resource = MstKotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
