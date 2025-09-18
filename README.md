# Bites Common Laravel Filament Package

This Laravel Composer package provides common features such as Measurements and Snapshot with Camera.

## Installation

Install the package via Composer:

```bash
composer require bit-es/common
```

## Usage

### Configuration in Model

```php
<?php

namespace .......

use Bites\Common\Traits\HasMeasurements;
use Bites\Common\Traits\HasCamera;

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
            \Bites\Common\Relations\Measurements::class,
            \Bites\Common\Relations\Camera::class,
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
                \Bites\Common\CommonPlugin::make(),
            ])
            ->......;
    }
}
```

## License

This package is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
