<?php

namespace App\Filament\Resources\MstKecamatans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MstKecamatanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id_kecamatan')
                    ->label('ID Kecamatan'),
                TextEntry::make('kode_kecamatan')
                    ->label('Kode Kecamatan'),
            ]);
    }
}
