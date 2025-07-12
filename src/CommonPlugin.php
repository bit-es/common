<?php

namespace Bites\Common;


use Bites\Common\Filament\Resources\TaskResource;
use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Concerns\EvaluatesClosures;

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
        $panel
            ->resources([
                TaskResource::class,
                
            ]);
    }

    public function boot(Panel $panel): void
    {
        $panel
            ->resources([
                TaskResource::class,
                
            ]);
    }
}
