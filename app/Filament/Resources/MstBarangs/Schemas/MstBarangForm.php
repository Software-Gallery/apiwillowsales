<?php

namespace App\Filament\Resources\MstBarangs\Schemas;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use App\Models\mst_barang;

use Filament\Schemas\Schema;

class MstBarangForm
{
    public static function configure(Schema $schema): Schema
    {   
        $nextNumber = substr(mst_barang::max('kode_barang')??'00000',1)+1;
        $generatedKode = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

        return $schema
            ->components([
                // TextInput::make('id_barang')
                //     ->label('ID Barang')
                //     ->numeric()
                //     ->required(),

                TextInput::make('kode_barang')
                    ->label('Kode Barang')
                    ->maxLength(50)
                    ->default($generatedKode)
                    ->required(),

                TextInput::make('nama_barang')
                    ->label('Nama Barang')
                    ->maxLength(255),

                TextInput::make('satuan_besar')
                    ->label('Satuan Besar')
                    ->numeric()
                    ->nullable(),

                TextInput::make('satuan_tengah')
                    ->label('Satuan Tengah')
                    ->numeric()
                    ->nullable(),

                TextInput::make('satuan_kecil')
                    ->label('Satuan Kecil')
                    ->numeric()
                    ->nullable(),

                TextInput::make('konversi_besar')
                    ->label('Konversi Besar')
                    ->numeric()
                    ->nullable()
                    ->step(0.0000000001), // 10 decimal places

                TextInput::make('konversi_tengah')
                    ->label('Konversi Tengah')
                    ->numeric()
                    ->nullable()
                    ->step(0.0000000001),

                FileUpload::make('gambar')
                    ->label('Gambar')
                    ->image()
                    ->nullable(),
            ]);
    }
}
