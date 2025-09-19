<?php

namespace App\Filament\Resources\MstSatuans\Pages;

use App\Filament\Resources\MstSatuans\MstSatuanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstSatuans extends ListRecords
{
    protected static string $resource = MstSatuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
