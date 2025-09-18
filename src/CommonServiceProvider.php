<?php

namespace Bites\Common;

use Bites\Common\Filament\Resources;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'bites');

        // \Livewire\Livewire::component('bites.common.filament.resources.manage-tasks', ManageTasks::class);
        // \Livewire\Livewire::component('bites.common.filament.resources.manage-photos', ManagePhotos::class);

        // Register TaskResource in the Filament panel
        // Filament::registerResources([
        //     Resources\MeasurementConfigs\MeasurementConfigResource::class,
        //     Resources\Measurements\MeasurementResource::class,
        // ]);
    }
}
