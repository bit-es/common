<?php

namespace Bites\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrgStructure extends Model
{
    protected $guarded = [];

    /**
     * Parent unit (division/department)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(OrgStructure::class, 'parent_id');
    }

    /**
     * Child units (departments/teams)
     */
    public function children(): HasMany
    {
        return $this->hasMany(OrgStructure::class, 'parent_id');
    }

    protected $casts = [
        'type' => 'string',
    ];

    public function getFullPathAttribute(): string
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }

    public function scopeTopLevel($query)
    {
        return $query->whereNull('parent_id');
    }

    protected static function booted()
    {
        static::saving(function ($structure) {
            if ($structure->parent_id && ! $structure->company_id) {
                $structure->company_id = self::find($structure->parent_id)?->company_id;
            }
        });
    }
}
