<?php

namespace App\Filament\Resources\MstDepartemens\Pages;

use App\Filament\Resources\MstDepartemens\MstDepartemenResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMstDepartemen extends EditRecord
{
    protected static string $resource = MstDepartemenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
