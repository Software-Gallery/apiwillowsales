<?php

namespace App\Filament\Resources\MstKaryawans;

use App\Filament\Resources\MstKaryawans\Pages\CreateMstKaryawan;
use App\Filament\Resources\MstKaryawans\Pages\EditMstKaryawan;
use App\Filament\Resources\MstKaryawans\Pages\ListMstKaryawans;
use App\Filament\Resources\MstKaryawans\Pages\ViewMstKaryawan;
use App\Filament\Resources\MstKaryawans\Schemas\MstKaryawanForm;
use App\Filament\Resources\MstKaryawans\Schemas\MstKaryawanInfolist;
use App\Filament\Resources\MstKaryawans\Tables\MstKaryawansTable;
use App\Models\mst_karyawan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MstKaryawanResource extends Resource
{
    protected static ?string $model = mst_karyawan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;
    
    // protected static string $navigationGroup = 'User';

    public static function form(Schema $schema): Schema
    {
        return MstKaryawanForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MstKaryawanInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MstKaryawansTable::configure($table);
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
            'index' => ListMstKaryawans::route('/'),
            'create' => CreateMstKaryawan::route('/create'),
            'view' => ViewMstKaryawan::route('/{record}'),
            'edit' => EditMstKaryawan::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Karyawan';
    }
        
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getPluralModelLabel(): string
    {
        return 'Karyawan';
    }
}
