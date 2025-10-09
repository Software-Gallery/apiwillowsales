<?php

namespace App\Filament\Resources\MstDepartemens\Schemas;
use Filament\Forms\Components\TextInput;
use App\Models\mst_departemen;

use Filament\Schemas\Schema;

class MstDepartemenForm
{
    public static function configure(Schema $schema): Schema
    {   
        $nextNumber = substr(mst_departemen::max('kode_departemen')??'00000',1)+1;
        $generatedKode = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);            
        return $schema
            ->components([
                TextInput::make('id_departemen')
                    ->label('ID Departemen')
                    ->required()
                    ->numeric(),

                TextInput::make('kode_departemen')
                    ->label('Kode Departemen')
                    ->required()
                    ->default($generatedKode)
                    ->maxLength(50),

                TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(100),
            ]);
    }
}
