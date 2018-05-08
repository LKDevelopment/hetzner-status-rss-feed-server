<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    public $fillable = ['type', 'keyword', 'user_agent'];

    public static function track(string $type, string $keyword, string $user_agent = null): Tracking
    {
        return Tracking::create(compact('type', 'keyword', 'user_agent'));
    }
}
