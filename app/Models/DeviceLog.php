<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceLog extends Model
{
    protected $fillable = [
        'device_id',
        'level',
        'type',
        'message',
        'details',
        'source',
        'logged_at',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
        'details' => 'array',
    ];

    /**
     * Get the device that owns this log.
     */
    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Scope a query to only include logs of a given level.
     */
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Scope a query to only include error and critical logs.
     */
    public function scopeErrors($query)
    {
        return $query->whereIn('level', ['error', 'critical']);
    }

    /**
     * Scope a query to only include logs from a specific device.
     */
    public function scopeForDevice($query, $deviceId)
    {
        return $query->where('device_id', $deviceId);
    }

    /**
     * Get the badge color based on log level.
     */
    public function getLevelColorAttribute(): string
    {
        return match($this->level) {
            'info' => 'blue',
            'warning' => 'yellow',
            'error' => 'red',
            'critical' => 'purple',
            default => 'gray',
        };
    }
}
