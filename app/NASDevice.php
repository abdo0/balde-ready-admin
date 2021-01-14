<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NASDevice extends Model
{
    protected $table         = 'nas_device';
    protected $primaryKey    = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
}
