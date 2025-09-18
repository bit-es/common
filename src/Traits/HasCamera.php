<?php

namespace Bites\Common\Traits;

use Bites\Common\Models\Camera;
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
