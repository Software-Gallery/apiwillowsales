<?php

namespace App\Filament\Resources\MstProvinsis\Pages;

use App\Filament\Resources\MstProvinsis\MstProvinsiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMstProvinsi extends EditRecord
{
    protected static string $resource = MstProvinsiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
