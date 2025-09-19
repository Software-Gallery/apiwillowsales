<?php

namespace App\Filament\Resources\TrnSalesOrderHeaders;

use App\Filament\Resources\TrnSalesOrderHeaders\Pages\CreateTrnSalesOrderHeader;
use App\Filament\Resources\TrnSalesOrderHeaders\Pages\EditTrnSalesOrderHeader;
use App\Filament\Resources\TrnSalesOrderHeaders\Pages\ListTrnSalesOrderHeaders;
use App\Filament\Resources\TrnSalesOrderHeaders\Pages\ViewTrnSalesOrderHeader;
use App\Filament\Resources\TrnSalesOrderHeaders\Schemas\TrnSalesOrderHeaderForm;
use App\Filament\Resources\TrnSalesOrderHeaders\Schemas\TrnSalesOrderHeaderInfolist;
use App\Filament\Resources\TrnSalesOrderHeaders\Tables\TrnSalesOrderHeadersTable;
use App\Models\trn_sales_order_header;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TrnSalesOrderHeaderResource extends Resource
{
    protected static ?string $model = trn_sales_order_header::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;
    
    // protected static string $navigationGroup = 'Transaction';
    protected static string | UnitEnum | null $navigationGroup = 'Operasional';

    public static function form(Schema $schema): Schema
    {
        return TrnSalesOrderHeaderForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TrnSalesOrderHeaderInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrnSalesOrderHeadersTable::configure($table);
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
            'index' => ListTrnSalesOrderHeaders::route('/'),
            'create' => CreateTrnSalesOrderHeader::route('/create'),
            'view' => ViewTrnSalesOrderHeader::route('/{record}'),
            'edit' => EditTrnSalesOrderHeader::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Transaksi Sales Order Header';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Transaksi Sales Order Header';
    }
}
