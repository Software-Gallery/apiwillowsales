<?php

namespace App\Filament\Resources\MstDepartemens\Pages;

use App\Filament\Resources\MstDepartemens\MstDepartemenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstDepartemens extends ListRecords
{
    protected static string $resource = MstDepartemenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
