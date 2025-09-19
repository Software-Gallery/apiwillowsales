<?php

namespace App\Filament\Resources\MstKecamatans\Pages;

use App\Filament\Resources\MstKecamatans\MstKecamatanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMstKecamatan extends ViewRecord
{
    protected static string $resource = MstKecamatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
