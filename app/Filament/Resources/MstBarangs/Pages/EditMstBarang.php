<?php

namespace App\Filament\Resources\MstBarangs\Pages;

use App\Filament\Resources\MstBarangs\MstBarangResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMstBarang extends EditRecord
{
    protected static string $resource = MstBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
