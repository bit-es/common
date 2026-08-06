<?php

namespace Bites\Core\Filament\Resources\MeasurementConfigs\Pages;

use Bites\Core\Filament\Resources\MeasurementConfigs\MeasurementConfigResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMeasurementConfig extends EditRecord
{
    protected static string $resource = MeasurementConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
