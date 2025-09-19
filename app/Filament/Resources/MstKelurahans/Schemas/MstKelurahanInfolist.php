<?php

namespace App\Filament\Resources\MstKelurahans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MstKelurahanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id_kelurahan')
                    ->label('ID Kelurahan'),
                TextEntry::make('kode_kelurahan')
                    ->label('Kode Kelurahan'),
            ]);
    }
}
