<?php

namespace App\Model\Device;

use App\Model\Device;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class FeatureFlag extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['device_id', 'key', 'value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
