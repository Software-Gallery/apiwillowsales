<?php

namespace App\Filament\Resources\MstKaryawans\Pages;

use App\Filament\Resources\MstKaryawans\MstKaryawanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMstKaryawan extends EditRecord
{
    protected static string $resource = MstKaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
