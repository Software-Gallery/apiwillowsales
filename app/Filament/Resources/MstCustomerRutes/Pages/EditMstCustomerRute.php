<?php

namespace App\Filament\Resources\MstCustomerRutes\Pages;

use App\Filament\Resources\MstCustomerRutes\MstCustomerRuteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMstCustomerRute extends EditRecord
{
    protected static string $resource = MstCustomerRuteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
