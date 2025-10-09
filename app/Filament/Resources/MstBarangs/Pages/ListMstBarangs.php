<?php

namespace App\Filament\Resources\MstBarangs\Pages;

use App\Filament\Resources\MstBarangs\MstBarangResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMstBarangs extends ListRecords
{
    protected static string $resource = MstBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
    // protected function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make(),
    //     ];
    // }
}
