<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NASZone extends Model
{
    protected $table         = 'nas_zone';
    protected $primaryKey    = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'active'
    ];

    public function nas()
    {
        return $this->hasMany('App\NAS', 'zone_id', 'id');
    }
}
