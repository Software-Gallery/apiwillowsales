<?php

namespace App\Filament\Resources\MstKelurahans;

use App\Filament\Resources\MstKelurahans\Pages\CreateMstKelurahan;
use App\Filament\Resources\MstKelurahans\Pages\EditMstKelurahan;
use App\Filament\Resources\MstKelurahans\Pages\ListMstKelurahans;
use App\Filament\Resources\MstKelurahans\Pages\ViewMstKelurahan;
use App\Filament\Resources\MstKelurahans\Schemas\MstKelurahanForm;
use App\Filament\Resources\MstKelurahans\Schemas\MstKelurahanInfolist;
use App\Filament\Resources\MstKelurahans\Tables\MstKelurahansTable;
use App\Models\mst_kelurahan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MstKelurahanResource extends Resource
{
    protected static ?string $model = mst_kelurahan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;
    
    // protected static string $navigationGroup = 'Place';
    protected static string | UnitEnum | null $navigationGroup = 'Tempat';

    public static function form(Schema $schema): Schema
    {
        return MstKelurahanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MstKelurahanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstKelurahansTable::configure($table);
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
            'index' => ListMstKelurahans::route('/'),
            'create' => CreateMstKelurahan::route('/create'),
            'view' => ViewMstKelurahan::route('/{record}'),
            'edit' => EditMstKelurahan::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Kelurahan';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Kelurahan';
    }
}
