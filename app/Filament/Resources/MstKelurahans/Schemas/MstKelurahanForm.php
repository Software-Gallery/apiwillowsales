<?php

namespace App\Filament\Resources\MstKelurahans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MstKelurahanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_kelurahan')
                    ->label('Kode Kelurahan')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('Masukkan kode kelurahan'),
            ]);
    }
}
