<?php

namespace App\Filament\Resources\MstKelurahans\Pages;

use App\Filament\Resources\MstKelurahans\MstKelurahanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMstKelurahan extends EditRecord
{
    protected static string $resource = MstKelurahanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
