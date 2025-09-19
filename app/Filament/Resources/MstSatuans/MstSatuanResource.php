<?php

namespace App\Filament\Resources\MstSatuans;

use App\Filament\Resources\MstSatuans\Pages\CreateMstSatuan;
use App\Filament\Resources\MstSatuans\Pages\EditMstSatuan;
use App\Filament\Resources\MstSatuans\Pages\ListMstSatuans;
use App\Filament\Resources\MstSatuans\Pages\ViewMstSatuan;
use App\Filament\Resources\MstSatuans\Schemas\MstSatuanForm;
use App\Filament\Resources\MstSatuans\Schemas\MstSatuanInfolist;
use App\Filament\Resources\MstSatuans\Tables\MstSatuansTable;
use App\Models\mst_satuan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstSatuanResource extends Resource
{
    protected static ?string $model = mst_satuan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;
    
    // protected static string $navigationGroup = 'Item';
 
    public static function form(Schema $schema): Schema
    {
        return MstSatuanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MstSatuanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstSatuansTable::configure($table);
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
            'index' => ListMstSatuans::route('/'),
            'create' => CreateMstSatuan::route('/create'),
            'view' => ViewMstSatuan::route('/{record}'),
            'edit' => EditMstSatuan::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Satuan';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Satuan';
    }
}
