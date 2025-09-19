<?php

namespace App\Filament\Resources\MstProvinsis;

use App\Filament\Resources\MstProvinsis\Pages\CreateMstProvinsi;
use App\Filament\Resources\MstProvinsis\Pages\EditMstProvinsi;
use App\Filament\Resources\MstProvinsis\Pages\ListMstProvinsis;
use App\Filament\Resources\MstProvinsis\Schemas\MstProvinsiForm;
use App\Filament\Resources\MstProvinsis\Tables\MstProvinsisTable;
use App\Models\mst_provinsi;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MstProvinsiResource extends Resource
{
    protected static ?string $model = mst_provinsi::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static ?string $recordTitleAttribute = 'Provinsi';

    protected static string | UnitEnum | null $navigationGroup = 'Tempat';

    public static function form(Schema $schema): Schema
    {
        return MstProvinsiForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstProvinsisTable::configure($table);
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
            'index' => ListMstProvinsis::route('/'),
            'create' => CreateMstProvinsi::route('/create'),
            'edit' => EditMstProvinsi::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Provinsi';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Provinsi';
    }      
}
