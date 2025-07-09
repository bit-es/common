<?php

namespace Bites\Common\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Bites\Common\Models\Task;
use Bites\Common\Models\Photo;

trait HasCommon
{
public function tasks():MorphMany
    {
        return $this->morphMany(Task::class, 'taskable');
    }
    public function photos():MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}