<?php

namespace App\Filament\Resources\MstKecamatans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MstKecamatanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_kecamatan')
                    ->label('Kode Kecamatan')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('Masukkan kode kecamatan'),
            ]);
    }
}
