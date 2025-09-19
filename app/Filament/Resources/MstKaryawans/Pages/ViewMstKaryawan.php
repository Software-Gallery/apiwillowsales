<?php

namespace App\Filament\Resources\MstKaryawans\Pages;

use App\Filament\Resources\MstKaryawans\MstKaryawanResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMstKaryawan extends ViewRecord
{
    protected static string $resource = MstKaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
