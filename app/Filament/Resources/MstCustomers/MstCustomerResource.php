<?php

namespace App\Filament\Resources\MstCustomers;

use App\Filament\Resources\MstCustomers\Pages\CreateMstCustomer;
use App\Filament\Resources\MstCustomers\Pages\EditMstCustomer;
use App\Filament\Resources\MstCustomers\Pages\ListMstCustomers;
use App\Filament\Resources\MstCustomers\Pages\ViewMstCustomer;
use App\Filament\Resources\MstCustomers\Schemas\MstCustomerForm;
use App\Filament\Resources\MstCustomers\Schemas\MstCustomerInfolist;
use App\Filament\Resources\MstCustomers\Tables\MstCustomersTable;
use App\Models\mst_customer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstCustomerResource extends Resource
{
    protected static ?string $model = mst_customer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    
    // protected static string $navigationGroup = 'User';

    protected static ?string $recordTitleAttribute = 'Customer';

    public static function form(Schema $schema): Schema
    {
        return MstCustomerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MstCustomerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstCustomersTable::configure($table);
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
            'index' => ListMstCustomers::route('/'),
            'create' => CreateMstCustomer::route('/create'),
            'view' => ViewMstCustomer::route('/{record}'),
            'edit' => EditMstCustomer::route('/{record}/edit'),
        ];
    }
    public static function getModelLabel(): string
    {
        return 'Customer';
    }
    
public static function getNavigationBadge(): ?string
{
    return static::getModel()::count();
}

    public static function getPluralModelLabel(): string
    {
        return 'Customer';
    }        
}
