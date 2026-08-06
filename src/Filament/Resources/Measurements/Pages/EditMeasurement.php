<?php

namespace Bites\Core\Filament\Resources\Measurements\Pages;

use Bites\Core\Filament\Resources\Measurements\MeasurementResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMeasurement extends EditRecord
{
    protected static string $resource = MeasurementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
