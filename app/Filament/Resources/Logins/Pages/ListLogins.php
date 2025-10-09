<?php

namespace App\Filament\Resources\Logins\Pages;

use App\Filament\Resources\Logins\LoginResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLogins extends ListRecords
{
    protected static string $resource = LoginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
