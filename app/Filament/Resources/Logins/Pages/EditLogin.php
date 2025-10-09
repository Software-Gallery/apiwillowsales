<?php

namespace App\Filament\Resources\Logins\Pages;

use App\Filament\Resources\Logins\LoginResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLogin extends EditRecord
{
    protected static string $resource = LoginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
