<?php

namespace App\Filament\Resources\MstKotas\Pages;

use App\Filament\Resources\MstKotas\MstKotaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMstKota extends EditRecord
{
    protected static string $resource = MstKotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
