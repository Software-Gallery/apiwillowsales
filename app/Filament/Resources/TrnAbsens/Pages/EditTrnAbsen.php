<?php

namespace App\Filament\Resources\TrnAbsens\Pages;

use App\Filament\Resources\TrnAbsens\TrnAbsenResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditTrnAbsen extends EditRecord
{
    protected static string $resource = TrnAbsenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
