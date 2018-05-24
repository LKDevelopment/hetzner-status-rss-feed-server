<?php

namespace App\Model;

use App\Model\Device\FeatureFlag;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;


/**
 *
 */
class Device extends Model
{

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     *  Setup model event hooks
     */
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string)Uuid::generate(4);
        });
    }

    /**
     * @var array
     */
    protected $fillable = ['os', 'version', 'app_version', 'type', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trackings()
    {
        return $this->hasMany(\App\Model\Device\Tracking::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function feature_flags()
    {
        return $this->belongsToMany(FeatureFlag::class);
    }
}
