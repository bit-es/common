<?php

namespace Bites\Common\Filament\Resources\Measurements\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MeasurementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('measurement_config_id')
                    ->numeric(),
                TextInput::make('model_type')
                    ->required(),
                TextInput::make('model_id')
                    ->required()
                    ->numeric(),
                TextInput::make('input_value'),
                TextInput::make('unit_value'),
            ]);
    }
}
