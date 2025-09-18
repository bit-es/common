<?php

namespace Bites\Common\Filament\Resources\MeasurementConfigs\Schemas;

use Bites\Common\Enums\MeasurementCategory;
use Bites\Common\Enums\MeasurementInputType;
use Bites\Common\Enums\MeasurementUnitType;
use Bites\Common\Filament\Resources\MeasurementConfigs\Pages;
use Bites\Common\Models\MeasurementConfig;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\File;

class MeasurementConfigForm
{
    public static function configure(Schema $schema): Schema
    {

        //  $configs = MeasurementConfig::where('for_model', $get('for_model'))->get();
        // dd($configs);
        //             $segments = $configs->groupBy('segment')->map(function ($group) {
        //     return $group->pluck('name')->toArray();
        // })->filter()->toArray();
        return $schema
            ->components([
                ToggleButtons::make('category')
                    ->inline()
                    ->grouped()
                    ->enum(MeasurementCategory::class)
                    ->required(),
                Select::make('for_model')
                    ->label('Model')
                    ->options(self::getModelOptions())
                    ->required()
                    ->reactive(),
                Select::make('segment')
                    ->label('Segment')
                    ->options(function (callable $get) {
                        $forModel = $get('for_model');
                        if (! $forModel) {
                            return [];
                        }

                        return MeasurementConfig::query()
                            ->where('for_model', $forModel)
                            ->pluck('segment', 'segment')
                            ->unique()
                            ->toArray();
                    })
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->required(),
                    ])

                    ->createOptionUsing(function (array $data, callable $get) {
                        // Create a new MeasurementConfig record with the new segment
                        $newConfig = MeasurementConfig::create([
                            'segment' => $data['segment'],
                            'for_model' => $get('for_model'),
                            'name' => 'Placeholder Name', // You can customize this or make it dynamic
                        ]);

                        return $newConfig->segment;
                    })

                    ->required()
                    ->reactive()
                    ->disabled(fn (callable $get) => ! $get('for_model'))
                    ->hint('Select a model first'),
                TextInput::make('name')
                    ->required(),
                Select::make('input_type')
                    ->enum(MeasurementInputType::class)
                    ->nullable(),
                Select::make('unit_type')
                    ->enum(MeasurementUnitType::class)
                    ->nullable(),
                Textarea::make('input_option'),
                Textarea::make('unit_option'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMeasurementConfigs::route('/'),
            'create' => Pages\CreateMeasurementConfig::route('/create'),
            'edit' => Pages\EditMeasurementConfig::route('/{record}/edit'),
        ];
    }

    protected static function getModelOptions(): array
    {

        $models = collect(File::allFiles(app_path('Models')))
            ->map(function ($file) {
                return 'App\\Models\\'.$file->getFilenameWithoutExtension();
                // return $file->getFilenameWithoutExtension();
            })
            ->filter(function ($class) {
                return is_subclass_of($class, \Illuminate\Database\Eloquent\Model::class);
            })
            ->values()
            ->toArray();

        return $models;
    }
}
