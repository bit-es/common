<?php

namespace Bites\Common\Filament\Resources\Measurements\Pages;

use Bites\Common\Filament\Resources\Measurements\MeasurementResource;
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
