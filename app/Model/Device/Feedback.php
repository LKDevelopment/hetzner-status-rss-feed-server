<?php

namespace App\Model\Device;

use App\Model\Device;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ['device_id', 'current_version', 'rating', 'text'];

    public function device(){
        return $this->belongsTo(Device::class);
    }
}
