<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class StatusMeldung extends Model
{
    /**
     * @var array $table ->increments('id');
     * $table->string('title');
     * $table->text('text');
     * $table->string('category');
     * $table->string('date_time');
     * $table->timestamps();
     */
    public $fillable = [
        'title',
        'text',
        'category',
        'date_time',
        'external_id',
        'parent_id',
        'permalink',
    ];

    public $appends = [
        'children',
    ];

    public function getChildrenAttribute()
    {
        return $this->hasMany(StatusMeldung::class, 'parent_id', 'external_id');
    }

    public function scopeOnlyParents(Builder $builder)
    {
        $builder->whereNull('parent_id');
    }
}
