<?php

namespace App\Model;

use App\Model\Device\FeatureFlag;
use App\Model\Device\FeatureTracking;
use App\Model\Device\Feedback;
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
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasMany|\Illuminate\Database\Query\Builder|null|object
     */
    public function latest_track(){
        return $this->trackings()->latest()->first();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function feature_flags()
    {
        return $this->belongsToMany(FeatureFlag::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feature_tracking(){
        return $this->hasMany(FeatureTracking::class);
    }
    /**
     * @param \App\Model\Device\FeatureFlag $featureFlag
     *
     * @return bool
     */
    public function hasFeatureFlag(FeatureFlag $featureFlag)
    {
        return $this->feature_flags->reject(function (FeatureFlag $flag) use ($featureFlag) {
                return $flag->key != $featureFlag->key;
            })->count() == 1;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function feedback(){
        return $this->hasMany(Feedback::class);
    }
}
