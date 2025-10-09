<?php

namespace App\Filament\Resources\MstSatuans\Pages;

use App\Filament\Resources\MstSatuans\MstSatuanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMstSatuan extends ViewRecord
{
    protected static string $resource = MstSatuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
