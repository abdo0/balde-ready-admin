<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $primaryKey = false;
    public $timestamps = true;
    protected $fillable = [
        'key',
        'value'
    ];
}
