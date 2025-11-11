<?php

namespace App\Services;

use App\Models\Device;
use App\Models\WaterLevel;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class MqttService
{
    /**
     * Process water level data from MQTT
     *
     * @param array $data
     * @return void
     */
    public function handleWaterLevel(array $data)
    {
        try {
            $device = Device::where('device_id', $data['device_id'])->first();

            if (!$device) {
                Log::warning('MQTT: Device not found', ['device_id' => $data['device_id']]);
                return;
            }

            // Store water level reading
            WaterLevel::create([
                'device_id' => $device->id,
                'level' => $data['level'],
                'volume' => $data['volume'] ?? null,
                'capacity' => $data['capacity'] ?? null,
                'recorded_at' => isset($data['timestamp'])
                    ? Carbon::parse($data['timestamp'])
                    : now(),
            ]);

            // Update device status
            $device->update([
                'current_level' => $data['level'],
                'last_reading_at' => now(),
                'status' => 'online',
            ]);

            // Check for low/high level alerts
            $this->checkWaterLevelAlerts($device, $data['level']);

            // Update cache for real-time display
            Cache::put("device:{$device->id}:water_level", $data['level'], 300); // 5 minutes

            Log::info('MQTT: Water level processed', [
                'device_id' => $data['device_id'],
                'level' => $data['level']
            ]);

        } catch (\Exception $e) {
            Log::error('MQTT: Error processing water level', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
        }
    }

    /**
     * Process flow rate data from MQTT
     *
     * @param array $data
     * @return void
     */
    public function handleFlowRate(array $data)
    {
        try {
            $device = Device::where('device_id', $data['device_id'])->first();

            if (!$device) {
                Log::warning('MQTT: Device not found', ['device_id' => $data['device_id']]);
                return;
            }

            // Update device flow rate
            $device->update([
                'flow_rate' => $data['flow_rate'],
                'last_reading_at' => now(),
            ]);

            // Store in cache for real-time display
            Cache::put("device:{$device->id}:flow_rate", $data['flow_rate'], 300);

            Log::info('MQTT: Flow rate processed', [
                'device_id' => $data['device_id'],
                'flow_rate' => $data['flow_rate']
            ]);

        } catch (\Exception $e) {
            Log::error('MQTT: Error processing flow rate', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
        }
    }

    /**
     * Process pump status data from MQTT
     *
     * @param array $data
     * @return void
     */
    public function handlePumpStatus(array $data)
    {
        try {
            $device = Device::where('device_id', $data['device_id'])->first();

            if (!$device) {
                Log::warning('MQTT: Device not found', ['device_id' => $data['device_id']]);
                return;
            }

            // Update device pump status
            $device->update([
                'pump_status' => $data['status'],
                'running_time' => $data['running_time'] ?? null,
                'power_consumption' => $data['power_consumption'] ?? null,
                'last_reading_at' => now(),
            ]);

            // Store in cache
            Cache::put("device:{$device->id}:pump_status", $data['status'], 300);

            Log::info('MQTT: Pump status processed', [
                'device_id' => $data['device_id'],
                'status' => $data['status']
            ]);

        } catch (\Exception $e) {
            Log::error('MQTT: Error processing pump status', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
        }
    }

    /**
     * Process alert messages from MQTT
     *
     * @param array $data
     * @return void
     */
    public function handleAlert(array $data)
    {
        try {
            $device = Device::where('device_id', $data['device_id'])->first();

            if (!$device) {
                Log::warning('MQTT: Device not found', ['device_id' => $data['device_id']]);
                return;
            }

            // Log alert
            Log::warning('MQTT: Alert received', [
                'device_id' => $data['device_id'],
                'message' => $data['message'],
                'severity' => $data['severity'] ?? 'info'
            ]);

            // You can implement notification system here
            // For example, send email, SMS, or push notification

            // Store alert in database if you have an alerts table
            // Alert::create([...]);

        } catch (\Exception $e) {
            Log::error('MQTT: Error processing alert', [
                'error' => $e->getMessage(),
                'data' => $data
            ]);
        }
    }

    /**
     * Check water level and trigger alerts
     *
     * @param Device $device
     * @param float $level
     * @return void
     */
    protected function checkWaterLevelAlerts(Device $device, float $level)
    {
        // Check for low level
        if ($level < 20) {
            // Trigger low level alert
            Log::warning('Water level critically low', [
                'device_id' => $device->device_id,
                'level' => $level
            ]);

            // You can trigger notifications here
        }

        // Check for high level
        if ($level > 95) {
            // Trigger high level alert
            Log::warning('Water level critically high', [
                'device_id' => $device->device_id,
                'level' => $level
            ]);
        }
    }

    /**
     * Publish pump control command to MQTT (for future implementation)
     *
     * @param string $deviceId
     * @param string $command (on/off)
     * @return array
     */
    public function publishPumpCommand(string $deviceId, string $command)
    {
        // This will be used to publish commands back to the device
        // For now, return command data that frontend will publish

        return [
            'topic' => "/aquapulse/device/{$deviceId}/control",
            'payload' => [
                'command' => $command,
                'timestamp' => now()->toISOString(),
            ]
        ];
    }

    /**
     * Get device real-time data from cache
     *
     * @param int $deviceId
     * @return array
     */
    public function getRealtimeData(int $deviceId)
    {
        return [
            'water_level' => Cache::get("device:{$deviceId}:water_level", 0),
            'flow_rate' => Cache::get("device:{$deviceId}:flow_rate", 0),
            'pump_status' => Cache::get("device:{$deviceId}:pump_status", 'off'),
        ];
    }

    /**
     * Validate incoming MQTT message
     *
     * @param array $data
     * @param array $requiredFields
     * @return bool
     */
    protected function validateMessage(array $data, array $requiredFields)
    {
        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                Log::warning('MQTT: Missing required field', [
                    'field' => $field,
                    'data' => $data
                ]);
                return false;
            }
        }

        return true;
    }
}
