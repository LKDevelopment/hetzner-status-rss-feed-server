<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $fillable = [
        'title_en',
        'description_en',
        'affected_en',
        'permalink_en',
        'title_de',
        'description_de',
        'affected_de',
        'permalink_de',
        'category',
        'start',
        'end',
        'type',
        'external_id',
        'parent_id',
        'send_at'
    ];

    public $hidden = ['id', 'created_at', 'send_at', 'updated_at', 'parent_id'];

    public $with = ['children'];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope(function (Builder $builder) {
            $builder->orderByDesc('id');
        });
    }

    public function scopeOnlyParents(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }

    public function children()
    {
        return $this->hasMany(Message::class, 'parent_id', 'external_id');
    }

    public function parent()
    {
        return $this->belongsTo(Message::class, 'parent_id', 'external_id');
    }
}
