<?php

namespace App\Filament\Resources\MstKotas;

use App\Filament\Resources\MstKotas\Pages\CreateMstKota;
use App\Filament\Resources\MstKotas\Pages\EditMstKota;
use App\Filament\Resources\MstKotas\Pages\ListMstKotas;
use App\Filament\Resources\MstKotas\Pages\ViewMstKota;
use App\Filament\Resources\MstKotas\Schemas\MstKotaForm;
use App\Filament\Resources\MstKotas\Schemas\MstKotaInfolist;
use App\Filament\Resources\MstKotas\Tables\MstKotasTable;
use App\Models\mst_kota;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MstKotaResource extends Resource
{
    protected static ?string $model = mst_kota::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;
    
    // protected static string $navigationGroup = 'Place';

    protected static string | UnitEnum | null $navigationGroup = 'Tempat';

    protected static ?string $recordTitleAttribute = 'Kota';

    public static function form(Schema $schema): Schema
    {
        return MstKotaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MstKotaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstKotasTable::configure($table);
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
            'index' => ListMstKotas::route('/'),
            'create' => CreateMstKota::route('/create'),
            'view' => ViewMstKota::route('/{record}'),
            'edit' => EditMstKota::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Kota';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Kota';
    }            
}
