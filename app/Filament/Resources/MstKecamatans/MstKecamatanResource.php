<?php

namespace App\Filament\Resources\MstKecamatans;

use App\Filament\Resources\MstKecamatans\Pages\CreateMstKecamatan;
use App\Filament\Resources\MstKecamatans\Pages\EditMstKecamatan;
use App\Filament\Resources\MstKecamatans\Pages\ListMstKecamatans;
use App\Filament\Resources\MstKecamatans\Pages\ViewMstKecamatan;
use App\Filament\Resources\MstKecamatans\Schemas\MstKecamatanForm;
use App\Filament\Resources\MstKecamatans\Schemas\MstKecamatanInfolist;
use App\Filament\Resources\MstKecamatans\Tables\MstKecamatansTable;
use App\Models\mst_kecamatan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MstKecamatanResource extends Resource
{
    protected static ?string $model = mst_kecamatan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMapPin;
    
    // protected static string $navigationGroup = 'Place';

    protected static string | UnitEnum | null $navigationGroup = 'Tempat';

    public static function form(Schema $schema): Schema
    {
        return MstKecamatanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MstKecamatanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstKecamatansTable::configure($table);
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
            'index' => ListMstKecamatans::route('/'),
            'create' => CreateMstKecamatan::route('/create'),
            'view' => ViewMstKecamatan::route('/{record}'),
            'edit' => EditMstKecamatan::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Kecamatan';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Kecamatan';
    }
}
