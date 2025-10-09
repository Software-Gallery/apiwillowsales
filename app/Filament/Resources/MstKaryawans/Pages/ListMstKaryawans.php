<?php

namespace App\Filament\Resources\MstKaryawans\Pages;

use App\Filament\Resources\MstKaryawans\MstKaryawanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstKaryawans extends ListRecords
{
    protected static string $resource = MstKaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
