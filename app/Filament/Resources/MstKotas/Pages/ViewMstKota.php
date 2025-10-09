<?php

namespace App\Filament\Resources\MstKotas\Pages;

use App\Filament\Resources\MstKotas\MstKotaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMstKota extends ViewRecord
{
    protected static string $resource = MstKotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
