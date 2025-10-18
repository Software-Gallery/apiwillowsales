<?php

namespace App\Filament\Resources\TrnAbsens\Pages;

use App\Filament\Resources\TrnAbsens\TrnAbsenResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewTrnAbsen extends ViewRecord
{
    protected static string $resource = TrnAbsenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
