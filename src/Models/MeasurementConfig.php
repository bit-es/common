<?php

namespace Bites\Common\Models;

use Illuminate\Database\Eloquent\Model;

class MeasurementConfig extends Model
{
    protected $table = 'measurement_configs';

    protected $fillable = [
        'category', 'for_model', 'segment',
        'name', 'input_type', 'unit_type',
        'description', 'input_option', 'unit_option', 'single_record',
    ];

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }
}
