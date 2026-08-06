# Bites Core Laravel Filament Package

This Laravel Composer package provides core features such as Measurements and Snapshot with Camera.

## Installation

Install the package via Composer:

```bash
composer require bit-es/core
```

## Usage

### Configuration in Model

```php
<?php

namespace .......

use Bites\Core\Traits\HasMeasurements;
use Bites\Core\Traits\HasCamera;

use ......

class ...... extends Model
{
    use HasMeasurements, HasCamera;

    ...........
}
```

### Configuration in Filament Resource

```php
<?php

namespace .........

use .......

class ........ extends Resource
{
    .......

    public static function getRelations(): array
    {
        return [
            \Bites\Core\Relations\Measurements::class,
            \Bites\Core\Relations\Camera::class,
        ];
    }
}
```

### Configuration in Filament Panel Provider

```php
<?php

namespace ........

use ...........

class ......... extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->.......
            ->plugins([
                \Bites\Core\CorePlugin::make(),
            ])
            ->......;
    }
}
```

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
