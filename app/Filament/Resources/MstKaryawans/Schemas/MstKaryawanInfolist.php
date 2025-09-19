<?php

namespace App\Filament\Resources\MstKaryawans\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MstKaryawanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('id_karyawan')
                    ->label('ID Karyawan'),
                TextEntry::make('kode_karyawan')
                    ->label('Kode Karyawan'),
                TextEntry::make('nama')
                    ->label('Nama Karyawan'),
            ]);
    }
}
