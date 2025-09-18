<?php

namespace Bites\Common\Traits;

use Bites\Common\Models\Measurement;

trait HasMeasurements
{
    public function measurements()
    {
        return $this->morphMany(Measurement::class, 'measurable');
    }

    public function getMeasurement($name)
    {
        return $this->measurements()
            ->whereHas('config', fn ($q) => $q->where('name', $name))
            ->first();
    }
}
