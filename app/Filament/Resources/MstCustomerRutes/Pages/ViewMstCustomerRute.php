<?php

namespace App\Filament\Resources\MstCustomerRutes\Pages;

use App\Filament\Resources\MstCustomerRutes\MstCustomerRuteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMstCustomerRute extends ViewRecord
{
    protected static string $resource = MstCustomerRuteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
