<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'tenant_id',
        'status',
        'inflow_status',
        'last_seen',
    ];

    protected $casts = [
        'last_seen' => 'datetime',
    ];

    /**
     * Get the user associated with this device.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'device_id');
    }

    /**
     * Get the tenant that owns this device.
     */
    public function tenant()
    {
        return $this->belongsTo(User::class, 'tenant_id', 'tenant_id');
    }

    /**
     * Get the logs for this device.
     */
    public function logs()
    {
        return $this->hasMany(DeviceLog::class);
    }
}
