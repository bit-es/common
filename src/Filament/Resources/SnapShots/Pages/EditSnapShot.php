<?php

namespace Bites\Core\Filament\Resources\SnapShots\Pages;

use Bites\Core\Filament\Resources\SnapShots\SnapshotResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSnapShot extends EditRecord
{
    protected static string $resource = SnapShotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
