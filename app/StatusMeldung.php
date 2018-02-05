<?php

namespace App;

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
    ];
}
