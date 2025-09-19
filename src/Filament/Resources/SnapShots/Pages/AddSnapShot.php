<?php

namespace Bites\Common\Filament\Resources\SnapShots\Pages;

use Bites\Common\Filament\Resources\SnapShots\SnapshotResource;
use Bites\Common\Models\Camera;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class AddSnapshot extends Page
{
    protected static string $resource = SnapshotResource::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCamera;

    protected static string $view = 'bites::snapshot-page';

    public function saveSnapshot($snapshot, $modelId, $modelType, $done_route, $photo_tag, $title, $latitude, $longitude, $filepath = 'public/snapshots')
    {
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $snapshot));

        $modelName = Str::snake(class_basename($modelType));
        $date = now()->format('ymd');
        $unique = substr(uniqid(), -3);
        $filename = "{$modelName}{$date}{$unique}.png";


        // Determine disk and trim prefix
        if (Str::startsWith($filepath, 'private/')) {
            $disk = 'local';
            $relativePath = Str::replaceFirst('private/', '', $filepath);
        } else {
            $disk = 'public';
            $relativePath = Str::replaceFirst('public/', '', $filepath);
        }

        // Final storage path
        $storagePath = rtrim($relativePath, '/') . '/' . $filename;

        // Save image
        Storage::disk($disk)->put($storagePath, $imageData);

        // Create database record
        Camera::create([
            'snapshotable_id' => $modelId,
            'snapshotable_type' => $modelType,
            'created_by' => Auth::id(),
            'photo_tag' => $photo_tag,
            'value' => $storagePath,
            'title' => $title,
            'criteria' => $latitude . ',' . $longitude,
            'parent_id' => null,
        ]);

        $this->redirect($done_route);
    }
}
