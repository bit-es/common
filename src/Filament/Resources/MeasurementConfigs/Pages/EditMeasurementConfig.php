<?php

namespace Bites\Common\Filament\Resources\MeasurementConfigs\Pages;

use Bites\Common\Filament\Resources\MeasurementConfigs\MeasurementConfigResource;
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
