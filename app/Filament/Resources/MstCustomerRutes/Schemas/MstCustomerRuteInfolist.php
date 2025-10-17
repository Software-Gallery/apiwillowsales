<?php

namespace App\Filament\Resources\MstCustomerRutes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Checkbox;
use Filament\Schemas\Schema;

class MstCustomerRuteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('departemen.nama_departemen')
                    ->label('Departemen'),
                TextEntry::make('customer.nama_customer')
                    ->label('Customer'),
                TextEntry::make('karyawan.nama')
                    ->label('Karyawan'),
                Checkbox::make('day1')->label('Senin'),
                Checkbox::make('day2')->label('Selasa'),
                Checkbox::make('day3')->label('Rabu'),
                Checkbox::make('day4')->label('Kamis'),
                Checkbox::make('day5')->label('Jumat'),
                Checkbox::make('day6')->label('Sabtu'),
                Checkbox::make('day7')->label('Minggu'), 
                Checkbox::make('week1')->label('Minggu Ganjil'),
                Checkbox::make('week2')->label('Minggu Genap'),
            ]);
    }
}
