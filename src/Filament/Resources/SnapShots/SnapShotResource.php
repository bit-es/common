<?php

namespace Bites\Core\Filament\Resources\SnapShots;

use Bites\Core\Filament\Resources\SnapShots\Pages;
use Bites\Core\Filament\Resources\SnapShots\Schemas\SnapShotForm;
use Bites\Core\Filament\Resources\SnapShots\Tables\SnapShotsTable;
use Bites\Core\Models\Camera;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SnapShotResource extends Resource
{
    protected static ?string $model = Camera::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SnapShotForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SnapShotsTable::configure($table);
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
            'index' => Pages\ListSnapShots::route('/'),
            'create' => Pages\CreateSnapShot::route('/create'),
            'edit' => Pages\EditSnapShot::route('/{record}/edit'),
            // 'add' => Pages\AddSnapShot::route('/add'),
        ];
    }
}
