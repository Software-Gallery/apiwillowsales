<?php

namespace App\Filament\Resources\MstBarangs\Pages;

use App\Filament\Resources\MstBarangs\MstBarangResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMstBarang extends ViewRecord
{
    protected static string $resource = MstBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
