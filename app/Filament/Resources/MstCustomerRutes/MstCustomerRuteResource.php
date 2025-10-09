<?php

namespace App\Filament\Resources\MstCustomerRutes;

use App\Filament\Resources\MstCustomerRutes\Pages\CreateMstCustomerRute;
use App\Filament\Resources\MstCustomerRutes\Pages\EditMstCustomerRute;
use App\Filament\Resources\MstCustomerRutes\Pages\ListMstCustomerRutes;
use App\Filament\Resources\MstCustomerRutes\Pages\ViewMstCustomerRute;
use App\Filament\Resources\MstCustomerRutes\Schemas\MstCustomerRuteForm;
use App\Filament\Resources\MstCustomerRutes\Schemas\MstCustomerRuteInfolist;
use App\Filament\Resources\MstCustomerRutes\Tables\MstCustomerRutesTable;
use App\Models\mst_customer_rute;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstCustomerRuteResource extends Resource
{
    protected static ?string $model = mst_customer_rute::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTruck;
    
    // protected static string $navigationGroup = 'Route';

    public static function form(Schema $schema): Schema
    {
        return MstCustomerRuteForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MstCustomerRuteInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstCustomerRutesTable::configure($table);
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
            'index' => ListMstCustomerRutes::route('/'),
            'create' => CreateMstCustomerRute::route('/create'),
            'view' => ViewMstCustomerRute::route('/{record}'),
            'edit' => EditMstCustomerRute::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Customer Rute';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Customer Rute';
    }
}
