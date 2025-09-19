<?php

namespace App\Filament\Resources\MstBarangs;

use App\Filament\Resources\MstBarangs\Pages\CreateMstBarang;
use App\Filament\Resources\MstBarangs\Pages\EditMstBarang;
use App\Filament\Resources\MstBarangs\Pages\ListMstBarangs;
use App\Filament\Resources\MstBarangs\Pages\ViewMstBarang;
use App\Filament\Resources\MstBarangs\Schemas\MstBarangForm;
use App\Filament\Resources\MstBarangs\Schemas\MstBarangInfolist;
use App\Filament\Resources\MstBarangs\Tables\MstBarangsTable;
use App\Models\mst_barang;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class MstBarangResource extends Resource
{
    protected static ?string $model = mst_barang::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;
    
    // protected static string $navigationGroup = 'Item';

    protected static ?string $recordTitleAttribute = 'Barang';

    public static function form(Schema $schema): Schema
    {
        return MstBarangForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MstBarangInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstBarangsTable::configure($table);
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
            'index' => ListMstBarangs::route('/'),
            'create' => CreateMstBarang::route('/create'),
            'view' => ViewMstBarang::route('/{record}'),
            'edit' => EditMstBarang::route('/{record}/edit'),
        ];
    }
    public static function getModelLabel(): string
    {
        return 'Barang';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Barang'; // atau "Daftar Barang", bebas
    }
    
    
}
