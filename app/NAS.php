<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NAS extends Model
{
    protected $table         = 'nas';
    protected $primaryKey    = 'id';
    public $timestamps = false;
    protected $fillable = [
        'nas_ip',
        'nas_username',
        'nas_password',
        'nas_ssh_port',
        'nas_device_type',
        'check_reach',
        'active',
        'zone_id'
    ];

    protected $appends = ['ping_time' ];

    public function getPingTimeAttribute()
    {
        $ip_address = '127.0.0.1';
        exec("ping -c 1 " . $ip_address . " | head -n 2 | tail -n 1 | awk '{print $7}'", $ping_time);
        $data  = substr($ping_time[0],5);
        return $this->ping_time = $data;
    }

    public function zoneName()
    {
        return $this->hasOne('App\NASZone', 'id', 'zone_id');
    }

    public function nasDevice()
    {
        return $this->hasOne('App\NASDevice', 'id', 'nas_device_type');
    }
}
