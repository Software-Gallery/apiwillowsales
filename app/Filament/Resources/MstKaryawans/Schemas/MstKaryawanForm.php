<?php

namespace App\Filament\Resources\MstKaryawans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MstKaryawanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_karyawan')
                    ->label('Kode Karyawan')
                    ->required()
                    ->maxLength(50)
                    ->placeholder('Masukkan kode karyawan'),
                TextInput::make('nama')
                    ->label('Nama Karyawan')
                    ->maxLength(100)
                    ->placeholder('Masukkan nama karyawan'),
            ]);
    }
}
