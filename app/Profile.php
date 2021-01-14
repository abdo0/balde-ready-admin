<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table         = 'profile';
    protected $primaryKey    = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'active',
        'zone_active',
        'zone_id',
        'nas_active',
        'nas_id',
        'all_rule'
    ];


    public function profileRuleList()
    {
        return $this->hasMany('App\ProfileRule', 'profile_id', 'id')->select('id','profile_id','name','active');
    }
}
