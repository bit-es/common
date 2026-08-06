<?php

namespace Bites\Core\Filament\Resources\SnapShots\Pages;

use Bites\Core\Filament\Resources\SnapShots\SnapshotResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSnapShots extends ListRecords
{
    protected static string $resource = SnapShotResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
