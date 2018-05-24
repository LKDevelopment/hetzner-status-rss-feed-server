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
    protected $fillable = ['key', 'min_build', 'description'];

    /**
     * @var array
     */
    protected $hidden = ['created_at', 'id', 'updated_at'];

    /**
     * @var array
     */
    protected $appends = ['value'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function devices()
    {
        return $this->belongsToMany(Device::class);
    }

    /**
     * @return bool
     */
    public function getValueAttribute()
    {
        return true;
    }
}
