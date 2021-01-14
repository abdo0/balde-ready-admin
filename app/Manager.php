<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    protected $table         = 'manager';
    protected $primaryKey    = 'id';
    public $timestamps = false;
    protected $fillable = [
        'profile_id',
        'profile_rule_id',
        'profile_rule_value'
    ];

    public function profileRuleName(){
        return $this->hasOne('\App\ProfileRule','id','profile_rule_id')->select('id', 'name');
    }
}
