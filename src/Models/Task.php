<?php

namespace Bites\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Task extends Model
{
    protected $table = 'cmn_tasks';
    
    protected $guarded = [];

    public function taskable(): MorphTo
    {
        return $this->morphTo();
    }
}
