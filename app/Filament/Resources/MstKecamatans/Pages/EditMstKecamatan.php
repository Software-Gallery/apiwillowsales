<?php

namespace App\Filament\Resources\MstKecamatans\Pages;

use App\Filament\Resources\MstKecamatans\MstKecamatanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMstKecamatan extends EditRecord
{
    protected static string $resource = MstKecamatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
