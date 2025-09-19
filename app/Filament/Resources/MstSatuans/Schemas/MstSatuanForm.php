<?php

namespace App\Filament\Resources\MstSatuans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MstSatuanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_satuan')
                    ->label('Kode Satuan')
                    ->required()
                    ->maxLength(5)
                    ->placeholder('Masukkan kode satuan'),
            ]);
    }
}
