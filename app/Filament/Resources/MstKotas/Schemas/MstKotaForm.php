<?php

namespace App\Filament\Resources\MstKotas\Schemas;
use Filament\Forms\Components\TextInput;
use App\Models\mst_kota;

use Filament\Schemas\Schema;

class MstKotaForm
{
    public static function configure(Schema $schema): Schema
    {
        $nextNumber = substr(mst_kota::max('kode_kota')??'00000',1)+1;
        $generatedKode = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);        
        return $schema
            ->components([
                TextInput::make('id_kota')
                    ->label('ID Kota')
                    ->required()
                    ->numeric(),

                TextInput::make('kode_kota')
                    ->label('Kode Kota')
                    ->required()
                    ->default($generatedKode)
                    ->maxLength(50),
            ]);
    }
}
