<?php

namespace App\Filament\Resources\MstCustomers\Schemas;
use Filament\Forms\Components\TextInput;
use App\Models\mst_customer;

use Filament\Schemas\Schema;

class MstCustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        $nextNumber = substr(mst_customer::max('kode_customer')??'00000',1)+1;
        $generatedKode = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        return $schema
            ->components([
                TextInput::make('kode_customer')
                ->label('Kode Customer')
                ->maxLength(50)
                ->default($generatedKode)
                ->required(),
    
            TextInput::make('nama')
                ->label('Nama')
                ->maxLength(100)
                ->nullable(),
    
            TextInput::make('alamat')
                ->label('Alamat')
                ->maxLength(200)
                ->nullable(),
    
            TextInput::make('id_provinsi')
                ->label('ID Provinsi')
                ->numeric()
                ->nullable(),
    
            TextInput::make('id_kota')
                ->label('ID Kota')
                ->numeric()
                ->nullable(),
    
            TextInput::make('id_kecamatan')
                ->label('ID Kecamatan')
                ->numeric()
                ->nullable(),
    
            TextInput::make('id_kelurahan')
                ->label('ID Kelurahan')
                ->numeric()
                ->nullable(),
    
            TextInput::make('kode_pos')
                ->label('Kode Pos')
                ->maxLength(5)
                ->nullable(),
    
            TextInput::make('latitutde')
                ->label('Latitude')
                ->numeric()
                ->step(0.00000001)
                ->nullable(),
    
            TextInput::make('longitude')
                ->label('Longitude')
                ->numeric()
                ->step(0.00000001)
                ->nullable(),
            ]);
    }
}
