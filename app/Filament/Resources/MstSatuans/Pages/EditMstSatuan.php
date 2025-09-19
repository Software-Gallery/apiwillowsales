<?php

namespace App\Filament\Resources\MstSatuans\Pages;

use App\Filament\Resources\MstSatuans\MstSatuanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMstSatuan extends EditRecord
{
    protected static string $resource = MstSatuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
