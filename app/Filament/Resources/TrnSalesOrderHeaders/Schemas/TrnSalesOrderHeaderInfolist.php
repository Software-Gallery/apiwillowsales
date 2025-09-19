<?php

namespace App\Filament\Resources\TrnSalesOrderHeaders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Schemas\Schema;

class TrnSalesOrderHeaderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Sales Order')
                    ->schema([
                        TextEntry::make('kode_sales_order')
                            ->label('Kode Sales Order'),
                        TextEntry::make('tgl_sales_order')
                            ->label('Tanggal Sales Order')
                            ->date(),
                    ])
                    ->columns(2),

                Section::make('Informasi Relasi')
                    ->schema([
                        TextEntry::make('departemen.nama_departemen')
                            ->label('Departemen'),
                        TextEntry::make('customer.nama_customer')
                            ->label('Customer'),
                        TextEntry::make('karyawan.nama')
                            ->label('Karyawan'),
                    ])
                    ->columns(3),

                Section::make('Informasi Referensi')
                    ->schema([
                        TextEntry::make('no_ref')
                            ->label('Nomor Referensi'),
                        TextEntry::make('tgl_ref')
                            ->label('Tanggal Referensi')
                            ->date(),
                    ])
                    ->columns(2),

                Section::make('Informasi Tambahan')
                    ->schema([
                        TextEntry::make('keterangan')
                            ->label('Keterangan'),
                        TextEntry::make('total')
                            ->label('Total')
                            ->money('IDR'),
                    ])
                    ->columns(2),
            ]);
    }
}
