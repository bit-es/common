<?php

namespace Bites\Common;

use Bites\Common\Filament\Resources;
use Closure;
use Filament\Facades\Filament;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\Support\Facades\Route;

class CommonPlugin implements Plugin
{
    use EvaluatesClosures;

    public Closure|bool $access = true;

    public Closure|int $sort = 100;

    public Closure|string $icon = '';

    public Closure|string $navigationGroup = '';

    public Closure|string $title = '';

    public Closure|string $navigationLabel = '';

    public function getId(): string
    {
        return 'common';
    }

    public function register(Panel $panel): void
    {
        // dump('here register');
        $panel
            ->resources([
                Resources\MeasurementConfigs\MeasurementConfigResource::class,
                Resources\Measurements\MeasurementResource::class,
                 Resources\Snapshots\SnapshotResource::class,
            ]);
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function boot(Panel $panel): void
    {
        // dump('here boot');
        $panel
            ->resources([
                Resources\MeasurementConfigs\MeasurementConfigResource::class,
                Resources\Measurements\MeasurementResource::class,
                Resources\Snapshots\SnapshotResource::class,
            ]);
    }
        public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public static function getCreateSnapshotUrl(array $params = []): ?string
    {
        // dd(  Resources\SnapshotResource::getPages()['create']->getPage());
        // dd(Filament::getPanels());
        foreach (Filament::getPanels() as $panel) {
            // dump(in_array(SnapshotResource::class, $panel->getResources()));
            if (in_array(  Resources\Snapshots\SnapshotResource::class, $panel->getResources())) {
                return $panel->getUrl('create', $params);
            }
        }

        return null;
    }


    public static function getCreateSnapshotRouteFromPage(array $params = []): ?string
    {
        $pageClass =   Resources\Snapshots\SnapshotResource::getPages()['create']->getPage();

        foreach (Route::getRoutes() as $route) {
            $action = $route->getAction();

            if (
                isset($action['uses']) &&
                is_string($action['uses']) &&
                str_contains($action['uses'], $pageClass)
            ) {
                return route($route->getName(), $params);
            }
        }

        return null;
    }
}
