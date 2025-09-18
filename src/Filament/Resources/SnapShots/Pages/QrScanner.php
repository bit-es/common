<?php

namespace Bites\Common\Filament\Resources\SnapShots\Pages;

use Bites\Common\Filament\Resources\SnapShots\SnapshotResource;
use Filament\Resources\Pages\Page;

class QrScanner extends Page
{
    protected static string $resource = SnapshotResource::class;

    protected static string $view = 'bites::qr-scanner';
}
