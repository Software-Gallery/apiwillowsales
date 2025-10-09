<?php

namespace App\Filament\Resources\MstKecamatans\Pages;

use App\Filament\Resources\MstKecamatans\MstKecamatanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstKecamatans extends ListRecords
{
    protected static string $resource = MstKecamatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
