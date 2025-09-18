<?php

namespace Bites\Common\Filament\Resources\Measurements\Pages;

use Bites\Common\Filament\Resources\Measurements\MeasurementResource;
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
