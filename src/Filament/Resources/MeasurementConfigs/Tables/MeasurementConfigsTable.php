<?php

namespace Bites\Common\Filament\Resources\MeasurementConfigs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MeasurementConfigsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->groups([
                'for_model',
                'category',
            ])
            ->columns([
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('for_model')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('segment')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('input_type')
                    ->searchable(),
                TextColumn::make('unit_type')
                    ->searchable(),
                CheckboxColumn::make('single_record'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
