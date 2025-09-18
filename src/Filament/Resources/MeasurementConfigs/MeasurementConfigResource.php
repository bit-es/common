<?php

namespace Bites\Common\Filament\Resources\MeasurementConfigs;

use BackedEnum;
use Bites\Common\Filament\Resources\MeasurementConfigs\Pages\CreateMeasurementConfig;
use Bites\Common\Filament\Resources\MeasurementConfigs\Pages\EditMeasurementConfig;
use Bites\Common\Filament\Resources\MeasurementConfigs\Pages\ListMeasurementConfigs;
use Bites\Common\Filament\Resources\MeasurementConfigs\Schemas\MeasurementConfigForm;
use Bites\Common\Filament\Resources\MeasurementConfigs\Tables\MeasurementConfigsTable;
use Bites\Common\Models\MeasurementConfig;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MeasurementConfigResource extends Resource
{
    protected static ?string $model = MeasurementConfig::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Configurations';

    public static function form(Schema $schema): Schema
    {
        return MeasurementConfigForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeasurementConfigsTable::configure($table);
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
            'index' => ListMeasurementConfigs::route('/'),
            'create' => CreateMeasurementConfig::route('/create'),
            'edit' => EditMeasurementConfig::route('/{record}/edit'),
        ];
    }
}
