<?php

namespace Bites\Common\Filament\Resources\SnapShots;

use Bites\Common\Filament\Resources\SnapShots\Pages;
use Bites\Common\Filament\Resources\SnapShots\Schemas\SnapShotForm;
use Bites\Common\Filament\Resources\SnapShots\Tables\SnapShotsTable;
use Bites\Common\Models\Camera;
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
