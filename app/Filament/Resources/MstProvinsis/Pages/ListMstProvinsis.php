<?php

namespace App\Filament\Resources\MstProvinsis\Pages;

use App\Filament\Resources\MstProvinsis\MstProvinsiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstProvinsis extends ListRecords
{
    protected static string $resource = MstProvinsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            //CreateAction::make(),
        ];
    }
}
