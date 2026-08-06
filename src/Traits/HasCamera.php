<?php

namespace Bites\Core\Traits;

use Bites\Core\Models\Camera;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasCamera
{
    /**
     * Define a polymorphic one-to-many relationship to the Camera model.
     */
    public function camera(): MorphMany
    {
        return $this->morphMany(Camera::class, 'snapshotable');
    }
}
