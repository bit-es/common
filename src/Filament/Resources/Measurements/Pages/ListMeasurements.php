<?php

namespace Bites\Core\Filament\Resources\Measurements\Pages;

use Bites\Core\Filament\Resources\Measurements\MeasurementResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeasurements extends ListRecords
{
    protected static string $resource = MeasurementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
