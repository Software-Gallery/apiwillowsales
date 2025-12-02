<?php

namespace App\Filament\Resources\Logins\Schemas;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\Login;

class LoginForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_karyawan')
                    ->label('Karyawan')
                    ->required()
                    ->relationship('karyawan', 'nama'),
                    // ->searchable(),

                TextInput::make('name')
                    ->required()
                    ->label('Name')
                    ->maxLength(255),
                
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique(Login::class, 'email', fn ($record) => $record)
                    ->label('Email')
                    ->maxLength(255),
                
                TextInput::make('password')
                    ->required()
                    ->password()
                    ->label('Password')
                    ->maxLength(255),
            ]);
    }
}
