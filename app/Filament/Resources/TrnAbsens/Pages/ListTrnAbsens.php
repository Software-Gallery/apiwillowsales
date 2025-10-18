<?php

namespace App\Filament\Resources\TrnAbsens\Pages;

use App\Filament\Resources\TrnAbsens\TrnAbsenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrnAbsens extends ListRecords
{
    protected static string $resource = TrnAbsenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
