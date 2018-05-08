<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    public $fillable = ['type', 'keyword'];

    public static function track(string $type, string $keyword): Tracking
    {
        return Tracking::create(compact('type', 'keyword'));
    }
}
