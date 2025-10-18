<?php

namespace App\Filament\Resources\TrnAbsens\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Fieldset;

class TrnAbsenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('id_karyawan')
                    ->label('ID Karyawan')
                    ->required()
                    ->numeric(),
                TextInput::make('id_customer')
                    ->label('ID Customer')
                    ->required()
                    ->numeric(),
                TextInput::make('id_departemen')
                    ->label('ID Departemen')
                    ->required()
                    ->numeric(),
                TextInput::make('kode_sales_order')
                    ->nullable()
                    ->label('Kode Sales Order'),
                DatePicker::make('tgl')
                    ->required()
                    ->label('Tanggal'),
                TextInput::make('jam_masuk')
                    ->required()
                    ->label('Jam Masuk'),
                TextInput::make('jam_keluar')
                    ->nullable()
                    ->label('Jam Keluar'),
                TextInput::make('latitude')
                    ->required()
                    ->numeric()
                    ->label('Latitude'),
                TextInput::make('longitude')
                    ->required()
                    ->numeric()
                    ->label('Longitude'),
                TextInput::make('keterangan')
                    ->nullable()
                    ->label('Keterangan'),
                TextInput::make('alamat')
                    ->nullable()
                    ->label('Alamat'),
            ]);
    }
}
