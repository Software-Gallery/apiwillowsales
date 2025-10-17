<?php

namespace App\Filament\Resources\MstCustomerRutes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\CheckboxEntry;
use Filament\Infolists\Components\Section;
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
                CheckboxEntry::make('day1')->label('Senin'),
                CheckboxEntry::make('day2')->label('Selasa'),
                CheckboxEntry::make('day3')->label('Rabu'),
                CheckboxEntry::make('day4')->label('Kamis'),
                CheckboxEntry::make('day5')->label('Jumat'),
                CheckboxEntry::make('day6')->label('Sabtu'),
                CheckboxEntry::make('day7')->label('Minggu'), 
                CheckboxEntry::make('week1')->label('Minggu Ganjil'),
                CheckboxEntry::make('week2')->label('Minggu Genap'),                         
    }
}
