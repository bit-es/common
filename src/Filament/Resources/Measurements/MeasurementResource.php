<?php

namespace Bites\Core\Filament\Resources\Measurements;

use BackedEnum;
use Bites\Core\Filament\Resources\Measurements\Pages\CreateMeasurement;
use Bites\Core\Filament\Resources\Measurements\Pages\EditMeasurement;
use Bites\Core\Filament\Resources\Measurements\Pages\ListMeasurements;
use Bites\Core\Filament\Resources\Measurements\Schemas\MeasurementForm;
use Bites\Core\Filament\Resources\Measurements\Tables\MeasurementsTable;
use Bites\Core\Models\Measurement;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MeasurementResource extends Resource
{
    protected static ?string $model = Measurement::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string|UnitEnum|null $navigationGroup = 'Data Entries';

    public static function form(Schema $schema): Schema
    {
        return MeasurementForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeasurementsTable::configure($table);
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
            'index' => ListMeasurements::route('/'),
            'create' => CreateMeasurement::route('/create'),
            'edit' => EditMeasurement::route('/{record}/edit'),
        ];
    }
}
