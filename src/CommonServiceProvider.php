<?php

namespace Bites\Common;

use Bites\Common\Filament\Resources\ManageTasks;
use Bites\Common\Filament\Resources\ManagePhotos;
use Bites\Common\Filament\Resources\TaskResource;
use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

class CommonServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        \Livewire\Livewire::component('bites.common.filament.resources.manage-tasks', ManageTasks::class);
        \Livewire\Livewire::component('bites.common.filament.resources.manage-photos', ManagePhotos::class);

        // Register TaskResource in the Filament panel
            Filament::registerResources([
                TaskResource::class,
            ]);
    }
}
