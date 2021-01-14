<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileRule extends Model
{
    protected $table         = 'profile_rule';
    protected $primaryKey    = 'id';
    public $timestamps = false;
    protected $fillable = [
        'profile_id',
        'name',
        'active',
        'cisco_active',
        'cisco_policy_map',
        'cisco_class',
        'cisco_rate',
        'cisco_burst',
        'mikrotik_active',
        'mikrotik_type',
        'mikrotik_rate',
        'mikrotik_burst_rate',
        'mikrotik_burst_threshold',
        'mikrotik_burst_time',
        'mikrotik_classifier',
    ];
}
