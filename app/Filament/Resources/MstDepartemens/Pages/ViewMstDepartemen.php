<?php

namespace App\Filament\Resources\MstDepartemens\Pages;

use App\Filament\Resources\MstDepartemens\MstDepartemenResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMstDepartemen extends ViewRecord
{
    protected static string $resource = MstDepartemenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
