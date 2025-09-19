<?php

namespace App\Filament\Resources\MstKelurahans\Pages;

use App\Filament\Resources\MstKelurahans\MstKelurahanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstKelurahans extends ListRecords
{
    protected static string $resource = MstKelurahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
