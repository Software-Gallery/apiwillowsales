<?php

namespace App\Filament\Resources\MstKelurahans\Pages;

use App\Filament\Resources\MstKelurahans\MstKelurahanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMstKelurahan extends ViewRecord
{
    protected static string $resource = MstKelurahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
