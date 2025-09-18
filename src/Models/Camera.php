<?php

namespace Bites\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Camera extends Model
{
    protected $table = 'snapshots';

    protected $guarded = [];

    public function snapshotable()
    {
        return $this->morphTo();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function advance(): void
    {
        $this->save();
    }

    protected static function booted()
    {
        static::deleting(function ($camera) {
            if ($camera->value) {
                Storage::disk('public')->delete($camera->value);
            }
        });
    }
}
