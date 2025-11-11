<?php

return [

    /*
    |--------------------------------------------------------------------------
    | HiveMQ Broker Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for connecting to HiveMQ MQTT broker via WebSocket
    |
    */

    'broker_url' => env('HIVEMQ_BROKER_URL', 'broker.hivemq.com'),

    'ws_port' => env('HIVEMQ_WS_PORT', 8000),

    'ws_path' => env('HIVEMQ_WS_PATH', '/mqtt'),

    'username' => env('HIVEMQ_USERNAME', ''),

    'password' => env('HIVEMQ_PASSWORD', ''),

    'use_ssl' => env('HIVEMQ_USE_SSL', false),

    'client_id_prefix' => env('HIVEMQ_CLIENT_ID_PREFIX', 'aquapulse'),

    /*
    |--------------------------------------------------------------------------
    | MQTT Topics
    |--------------------------------------------------------------------------
    |
    | Define the MQTT topic structure for your application
    |
    */

    'topics' => [
        'water_level' => '/aquapulse/device/{device_id}/water_level',
        'flow_rate' => '/aquapulse/device/{device_id}/flow_rate',
        'pump_status' => '/aquapulse/device/{device_id}/pump_status',
        'alerts' => '/aquapulse/device/{device_id}/alerts',
        'control' => '/aquapulse/device/{device_id}/control',
    ],

    /*
    |--------------------------------------------------------------------------
    | Connection Settings
    |--------------------------------------------------------------------------
    */

    'keep_alive_interval' => 60, // seconds

    'reconnect_timeout' => 2000, // milliseconds

    'max_reconnect_attempts' => 10,

    'qos' => 0, // Quality of Service (0, 1, or 2)

];
