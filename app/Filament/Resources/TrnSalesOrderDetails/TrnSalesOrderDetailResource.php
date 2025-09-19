<?php

namespace App\Filament\Resources\TrnSalesOrderDetails;

use App\Filament\Resources\TrnSalesOrderDetails\Pages\CreateTrnSalesOrderDetail;
use App\Filament\Resources\TrnSalesOrderDetails\Pages\EditTrnSalesOrderDetail;
use App\Filament\Resources\TrnSalesOrderDetails\Pages\ListTrnSalesOrderDetails;
use App\Filament\Resources\TrnSalesOrderDetails\Schemas\TrnSalesOrderDetailForm;
use App\Filament\Resources\TrnSalesOrderDetails\Tables\TrnSalesOrderDetailsTable;
use App\Models\trn_sales_order_detail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TrnSalesOrderDetailResource extends Resource
{
    protected static ?string $model = trn_sales_order_detail::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $recordTitleAttribute = 'Transaksi Sales Order Detail';

    protected static string | UnitEnum | null $navigationGroup = 'Operasional';

    public static function form(Schema $schema): Schema
    {
        return TrnSalesOrderDetailForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrnSalesOrderDetailsTable::configure($table);
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
            'index' => ListTrnSalesOrderDetails::route('/'),
            'create' => CreateTrnSalesOrderDetail::route('/create'),
            'edit' => EditTrnSalesOrderDetail::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Transaksi Sales Order Detail';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Transaksi Sales Order Detail';
    }    
}
