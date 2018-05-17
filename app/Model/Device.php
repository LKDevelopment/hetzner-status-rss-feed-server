<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Spatie\BinaryUuid\HasBinaryUuid;

/**
 *
 */
class Device extends Model
{

    use HasBinaryUuid;

    /**
     * @var array
     */
    protected $fillable = ['os', 'version'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackings()
    {
        return $this->hasMany(\App\Model\Device\Tracking::class);
    }
}
