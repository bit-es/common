<?php

namespace Bites\Common\Relations;

use Bites\Common\Models\MeasurementConfig;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Measurements extends RelationManager
{
    protected static string $relationship = 'measurements';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Hidden::make('created_by')
                ->label('Created By')
                ->default(Auth::id())
                // ->relationship('creator', 'name')
                // ->disabled()
                // ->required()
                ->dehydrated(true),
            Hidden::make('measurement_config_id')
                ->dehydrated(true),
            ToggleButtons::make('segment')
                ->label('Segment')
                ->reactive()
                ->inline()
                ->dehydrated(false)
                ->grouped()
                ->options(fn () => $this->getBaseQuery()
                    ->pluck('segment')
                    ->unique()
                    ->mapWithKeys(fn ($segment) => [$segment => $segment])
                    ->toArray())
                ->required(fn () => $this->getBaseQuery()->pluck('segment')->isNotEmpty())
                ->afterStateHydrated(fn (callable $set) => $this->autoSelectSingle($set, 'segment'))
                ->afterStateUpdated(fn ($state, callable $set) => $set('name', null)),

            ToggleButtons::make('name')
                ->label('Key')
                ->reactive()
                ->inline()
                ->dehydrated(false)
                ->grouped()
                ->options(fn (callable $get) => $this->getBaseQuery()
                    ->where('segment', $get('segment'))
                    ->pluck('name')
                    ->unique()
                    ->mapWithKeys(fn ($name) => [$name => $name])
                    ->toArray())
                ->required(fn (callable $get) => $this->getBaseQuery()
                    ->where('segment', $get('segment'))
                    ->pluck('name')
                    ->isNotEmpty())
                ->afterStateHydrated(fn (callable $set, callable $get) => $this->autoSelectSingle($set, 'name', $get('segment')))
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $set('unit_option', null);

                    // Hydrate config fields from MeasurementConfig
                    $config = $this->getBaseQuery()
                        ->where('segment', $get('segment'))
                        ->where('name', $state)
                        ->first();

                    if ($config) {
                        $set('input_type', $config->input_type);
                        $set('input_option', $config->input_option);
                        $set('unit_type', $config->unit_type);
                        $set('unit_option', $config->unit_option);
                        $set('measurement_config_id', $config->id);
                    }
                }),

            ...$this->getDynamicValueComponents(),
            ...$this->getDynamicUnitComponents(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('config.segment')->label('Segment')->searchable(),
                TextColumn::make('config.name')->label('Key')->searchable(),
                TextColumn::make('value'),
                TextColumn::make('unit'),
                TextColumn::make('creator.name')->label('By')->searchable(),
                TextColumn::make('updated_at')->label('At')->searchable(),

            ])
            ->filters([
                //     \Filament\Tables\Filters\TernaryFilter::make('single_record')
                //         ->label('Single Record')
                //         ->queries(
                //             true: fn(Builder $query) => $query->whereHas('config', fn($q) => $q->where('single_record', true)),
                //             false: fn(Builder $query) => $query->whereHas('config', fn($q) => $q->where('single_record', false)),
                //             blank: fn(Builder $query) => $query,
                //         ),
            ])
            ->headerActions([
                CreateAction::make()->label('Add'),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /** 🔧 Helpers */
    private function getBaseQuery(): Builder
    {
        return MeasurementConfig::query()
            ->where('for_model', class_basename($this->getOwnerRecord()?->getMorphClass()));
    }

    private function getSplitOptions(Builder $query, string $column): Collection
    {
        return $query->pluck($column)
            ->flatMap(fn ($value) => explode(',', $value))
            ->map(fn ($value) => trim($value))
            ->unique()
            ->values();
    }

    private function autoSelectSingle(callable $set, string $field, ?string $segment = null, ?string $name = null): void
    {
        $query = $this->getBaseQuery();

        if ($segment) {
            $query->where('segment', $segment);
        }

        if ($name) {
            $query->where('name', $name);
        }

        $values = $field === 'unit_option'
            ? $this->getSplitOptions($query, 'unit_option')
            : $query->pluck($field)->unique()->values();

        if ($values->count() === 1) {
            $set($field, $values->first());
        }
    }

    private function getDynamicValueComponents(): array
    {
        return [
            TextInput::make('value')->label('Value')->required()
                ->visible(fn (callable $get) => $get('input_type') === 'TextInput'),
            Select::make('value')->label('Value')->required()
                ->options(fn (callable $get) => collect(explode(',', $get('input_option')))->mapWithKeys(fn ($opt) => [$opt => $opt])->toArray())
                ->visible(fn (callable $get) => $get('input_type') === 'Select'),
            ToggleButtons::make('value')->label('Value')->required()->inline()->grouped()
                ->options(fn (callable $get) => collect(explode(',', $get('input_option')))->mapWithKeys(fn ($opt) => [$opt => $opt])->toArray())
                ->visible(fn (callable $get) => $get('input_type') === 'ToggleButtons'),
            \Filament\Forms\Components\DatePicker::make('value')->label('Value')->required()
                ->visible(fn (callable $get) => $get('input_type') === 'DatePicker'),
            \Filament\Forms\Components\DateTimePicker::make('value')->label('Value')->required()
                ->visible(fn (callable $get) => $get('input_type') === 'DateTimePicker'),
            \Filament\Forms\Components\TimePicker::make('value')->label('Value')->required()
                ->visible(fn (callable $get) => $get('input_type') === 'TimePicker'),
            \Filament\Forms\Components\ColorPicker::make('value')->label('Value')->required()
                ->visible(fn (callable $get) => $get('input_type') === 'ColorPicker'),
            \Filament\Forms\Components\Slider::make('value')->label('Value')->required()
                ->visible(fn (callable $get) => $get('input_type') === 'Slider'),
            \Bites\Common\Filament\Resources\Support\ScanCode::make('value')->label('Value')->required()
                ->visible(fn (callable $get) => $get('input_type') === 'ScanCode'),

        ];

        // case CamInput = 'CamInput';
    }

    private function getDynamicUnitComponents(): array
    {
        return [
            TextInput::make('unit')
                ->label('Unit')
                ->visible(fn (callable $get) => $get('unit_type') === 'text')
                ->required(),
            ToggleButtons::make('unit')->label('Unit')->required()->inline()->grouped()
                ->options(fn (callable $get) => collect(explode(',', $get('unit_option')))->mapWithKeys(fn ($opt) => [$opt => $opt])->toArray())
                ->visible(fn (callable $get) => $get('unit_type') === 'ToggleButtons'),
        ];
    }
}
