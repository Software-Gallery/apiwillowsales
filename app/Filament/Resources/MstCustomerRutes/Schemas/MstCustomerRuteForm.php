<?php

namespace App\Filament\Resources\MstCustomerRutes\Schemas;

use App\Models\mst_departemen;
use App\Models\mst_customer;
use App\Models\mst_karyawan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Section;
use Filament\Schemas\Schema;

class MstCustomerRuteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Rute')
                    ->schema([
                        Select::make('id_departemen')
                            ->label('Departemen')
                            ->options(mst_departemen::pluck('nama_departemen', 'id_departemen'))
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih departemen'),
                        
                        Select::make('id_customer')
                            ->label('Customer')
                            ->options(mst_customer::pluck('nama_customer', 'id_customer'))
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih customer'),
                        
                        Select::make('id_karyawan')
                            ->label('Karyawan')
                            ->options(mst_karyawan::pluck('nama', 'id_karyawan'))
                            ->required()
                            ->searchable()
                            ->placeholder('Pilih karyawan'),
                    ])
                    ->columns(3),

                Section::make('Jadwal Kunjungan')
                    ->schema([
                        Section::make('Hari')
                            ->schema([
                                Checkbox::make('day1')->label('Senin'),
                                Checkbox::make('day2')->label('Selasa'),
                                Checkbox::make('day3')->label('Rabu'),
                                Checkbox::make('day4')->label('Kamis'),
                                Checkbox::make('day5')->label('Jumat'),
                                Checkbox::make('day6')->label('Sabtu'),
                                Checkbox::make('day7')->label('Minggu'),
                            ])
                            ->columns(7),

                        Section::make('Minggu')
                            ->schema([
                                Checkbox::make('week1')->label('Minggu 1'),
                                Checkbox::make('week2')->label('Minggu 2'),
                                Checkbox::make('week3')->label('Minggu 3'),
                                Checkbox::make('week4')->label('Minggu 4'),
                            ])
                            ->columns(4),
                    ])
                    ->columns(2),
            ]);
    }
}
