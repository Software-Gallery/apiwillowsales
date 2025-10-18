<?php

namespace App\Filament\Resources\TrnAbsens;

use App\Filament\Resources\TrnAbsens\Pages\CreateTrnAbsen;
use App\Filament\Resources\TrnAbsens\Pages\EditTrnAbsen;
use App\Filament\Resources\TrnAbsens\Pages\ListTrnAbsens;
use App\Filament\Resources\TrnAbsens\Pages\ViewTrnAbsen;
use App\Filament\Resources\TrnAbsens\Schemas\TrnAbsenForm;
use App\Filament\Resources\TrnAbsens\Schemas\TrnAbsenInfolist;
use App\Filament\Resources\TrnAbsens\Tables\TrnAbsensTable;
use App\Models\trn_absen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TrnAbsenResource extends Resource
{
    protected static ?string $model = trn_absen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'Absen';

    public static function form(Schema $schema): Schema
    {
        return TrnAbsenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrnAbsenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrnAbsensTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrnAbsens::route('/'),
            'create' => CreateTrnAbsen::route('/create'),
            'view' => ViewTrnAbsen::route('/{record}'),
            'edit' => EditTrnAbsen::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Absen';
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPluralModelLabel(): string
    {
        return 'Absen';
    }    
}
