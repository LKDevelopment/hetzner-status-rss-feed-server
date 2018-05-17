<?php

namespace App\Model\Device;

use App\Model\Device;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Tracking extends Model
{

    /**
     * @var string
     */
    protected $table = 'device_trackings';
    /**
     * @var array
     */
    protected $fillable = ['projects', 'access', 'device_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
