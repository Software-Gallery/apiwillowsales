<?php

namespace App\Filament\Resources\MstDepartemens;

use App\Filament\Resources\MstDepartemens\Pages\CreateMstDepartemen;
use App\Filament\Resources\MstDepartemens\Pages\EditMstDepartemen;
use App\Filament\Resources\MstDepartemens\Pages\ListMstDepartemens;
use App\Filament\Resources\MstDepartemens\Pages\ViewMstDepartemen;
use App\Filament\Resources\MstDepartemens\Schemas\MstDepartemenForm;
use App\Filament\Resources\MstDepartemens\Schemas\MstDepartemenInfolist;
use App\Filament\Resources\MstDepartemens\Tables\MstDepartemensTable;
use App\Models\mst_departemen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstDepartemenResource extends Resource
{
    protected static ?string $model = mst_departemen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;
    
    // protected static string $navigationGroup = 'User';

    protected static ?string $recordTitleAttribute = 'Departemen';

    public static function form(Schema $schema): Schema
    {
        return MstDepartemenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MstDepartemenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstDepartemensTable::configure($table);
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
            'index' => ListMstDepartemens::route('/'),
            'create' => CreateMstDepartemen::route('/create'),
            'view' => ViewMstDepartemen::route('/{record}'),
            'edit' => EditMstDepartemen::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Departemen';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Departemen';
    }            
}
