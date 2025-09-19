<?php

namespace App\Filament\Resources\TrnSalesOrderHeaders\Schemas;

use App\Models\mst_departemen;
use App\Models\mst_customer;
use App\Models\mst_karyawan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Fieldset;
use Filament\Schemas\Schema;

class TrnSalesOrderHeaderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // FieldSet::make('Informasi Sales Order')
                //     ->schema([
                        TextInput::make('kode_sales_order')
                            ->label('Kode Sales Order')
                            ->required()
                            ->placeholder('Masukkan kode sales order'),
                        
                        DatePicker::make('tgl_sales_order')
                            ->label('Tanggal Sales Order')
                            ->required()
                            ->default(now()),
                    // ])
                    // ->columns(2),

                // FieldSet::make('Informasi Relasi')
                //     ->schema([
                        Select::make('id_departemen')
                            ->label('Departemen')
                            ->options(mst_departemen::pluck('keterangan', 'id_departemen'))
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih departemen'),
                        
                        Select::make('id_customer')
                            ->label('Customer')
                            ->options(mst_customer::pluck('nama', 'id_customer'))
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih customer'),
                        
                        Select::make('id_karyawan')
                            ->label('Karyawan')
                            ->options(mst_karyawan::pluck('nama', 'id_karyawan'))
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih karyawan'),
                    // ])
                    // ->columns(3),

                // FieldSet::make('Informasi Referensi')
                //     ->schema([
                        TextInput::make('no_ref')
                            ->label('Nomor Referensi')
                            ->placeholder('Masukkan nomor referensi'),
                        
                        DatePicker::make('tgl_ref')
                            ->label('Tanggal Referensi')
                            ->placeholder('Pilih tanggal referensi'),
                    // ])
                    // ->columns(2),

                // FieldSet::make('Informasi Tambahan')
                //     ->schema([
                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(3)
                            ->placeholder('Masukkan keterangan'),
                        
                        TextInput::make('total')
                            ->label('Total')
                            ->numeric()
                            ->prefix('Rp ')
                            ->placeholder('0'),
                    // ])
                    // ->columns(2),
            ]);
    }
}
