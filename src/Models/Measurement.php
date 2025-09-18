<?php

namespace Bites\Common\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    protected $table = 'measurements';

    protected $guarded = [];

    public function measurable()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function config()
    {
        return $this->belongsTo(MeasurementConfig::class, 'measurement_config_id');
    }
}
