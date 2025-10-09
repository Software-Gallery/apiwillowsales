<?php

namespace App\Filament\Resources\MstSatuans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MstSatuanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id_satuan')
                    ->label('ID Satuan'),
                TextEntry::make('kode_satuan')
                    ->label('Kode Satuan'),
            ]);
    }
}
