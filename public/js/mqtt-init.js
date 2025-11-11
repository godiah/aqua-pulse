/**
 * Initialize MQTT client for AquaPulse Dashboard
 */

// MQTT Client instance
let mqttClient = null;

// Initialize MQTT connection when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    initializeMQTT();
});

/**
 * Initialize MQTT client with configuration
 */
function initializeMQTT() {
    // Get configuration from window.mqttConfig (passed from blade template)
    // Fallback to defaults if not provided
    const config = window.mqttConfig || {
        hostname: 'broker.hivemq.com',
        port: 8884,
        path: '/mqtt',
        username: '',
        password: '',
        useSSL: false
    };

    console.log('[MQTT Init] Connecting with config:', {
        hostname: config.hostname,
        port: config.port,
        path: config.path,
        useSSL: config.useSSL
    });

    // Create MQTT client instance
    mqttClient = new MQTTClient(config);

    // Set event handlers
    mqttClient.onConnect = handleMQTTConnect;
    mqttClient.onDisconnect = handleMQTTDisconnect;
    mqttClient.onMessage = handleMQTTMessage;
    mqttClient.onError = handleMQTTError;

    // Connect to broker
    mqttClient.connect();
}

/**
 * Handle successful MQTT connection
 */
function handleMQTTConnect() {
    console.log('Dashboard: MQTT connected successfully');

    // Subscribe to device topics
    // Replace 'device_001' with your actual device ID
    const deviceId = getDeviceId(); // You'll need to implement this

    mqttClient.subscribe(`/aquapulse/device/${deviceId}/water_level`);
    mqttClient.subscribe(`/aquapulse/device/${deviceId}/flow_rate`);
    mqttClient.subscribe(`/aquapulse/device/${deviceId}/pump_status`);
    mqttClient.subscribe(`/aquapulse/device/${deviceId}/alerts`);

    // Show connection status
    showNotification('MQTT Connected', 'success');
}

/**
 * Handle MQTT disconnection
 */
function handleMQTTDisconnect(error) {
    console.warn('Dashboard: MQTT disconnected', error);
    showNotification('MQTT Disconnected', 'warning');
}

/**
 * Handle incoming MQTT messages
 */
function handleMQTTMessage(topic, data) {
    console.log('Dashboard: Received message', { topic, data });

    // Update dashboard UI based on message type
    if (topic.includes('water_level')) {
        updateWaterLevelUI(data);
    } else if (topic.includes('flow_rate')) {
        updateFlowRateUI(data);
    } else if (topic.includes('pump_status')) {
        updatePumpStatusUI(data);
    } else if (topic.includes('alerts')) {
        showAlert(data.message, data.severity);
    }
}

/**
 * Handle MQTT errors
 */
function handleMQTTError(error) {
    console.error('Dashboard: MQTT error', error);
    showNotification('MQTT Error: ' + error.message, 'error');
}

/**
 * Update water level UI
 */
function updateWaterLevelUI(data) {
    // Update gauge
    const gaugeText = document.querySelector('.gauge-text');
    if (gaugeText) {
        gaugeText.textContent = data.level + '%';
    }

    // Update stroke offset for gauge fill
    const gaugeFill = document.querySelector('.gauge-fill');
    if (gaugeFill) {
        const circumference = 502; // 2 * PI * radius (80)
        const offset = circumference - (circumference * data.level / 100);
        gaugeFill.style.strokeDashoffset = offset;
    }

    // Update volume display
    const volumeDisplay = document.querySelector('.current-volume');
    if (volumeDisplay && data.volume) {
        volumeDisplay.textContent = data.volume + ' Liters';
    }

    // Update last updated time
    updateLastUpdatedTime();
}

/**
 * Update flow rate UI
 */
function updateFlowRateUI(data) {
    const flowRateElement = document.querySelector('.flow-rate-value');
    if (flowRateElement && data.flow_rate !== undefined) {
        flowRateElement.textContent = data.flow_rate + ' L/min';
    }

    updateLastUpdatedTime();
}

/**
 * Update pump status UI
 */
function updatePumpStatusUI(data) {
    const pumpToggle = document.getElementById('pumpToggle');
    const statusIndicator = document.querySelector('.status-on, .status-off');

    if (pumpToggle) {
        pumpToggle.checked = data.status === 'on' || data.status === true;
    }

    if (statusIndicator) {
        if (data.status === 'on' || data.status === true) {
            statusIndicator.textContent = 'ON';
            statusIndicator.classList.remove('status-off');
            statusIndicator.classList.add('status-on');
        } else {
            statusIndicator.textContent = 'OFF';
            statusIndicator.classList.remove('status-on');
            statusIndicator.classList.add('status-off');
        }
    }

    // Update running time
    if (data.running_time) {
        const runningTimeElement = document.querySelector('.running-time');
        if (runningTimeElement) {
            runningTimeElement.textContent = data.running_time;
        }
    }

    // Update power consumption
    if (data.power_consumption) {
        const powerElement = document.querySelector('.power-consumption');
        if (powerElement) {
            powerElement.textContent = data.power_consumption + ' kWh';
        }
    }

    updateLastUpdatedTime();
}

/**
 * Control pump via MQTT
 */
function controlPump(command) {
    const deviceId = getDeviceId();

    if (!mqttClient || !mqttClient.isConnected) {
        showNotification('MQTT not connected', 'error');
        return;
    }

    // Publish control command
    mqttClient.publish(
        `/aquapulse/device/${deviceId}/control`,
        {
            command: command,
            timestamp: new Date().toISOString()
        }
    );

    console.log('Pump control command sent:', command);
}

/**
 * Get device ID from page or user session
 */
function getDeviceId() {
    // Try to get from data attribute
    const deviceElement = document.querySelector('[data-device-id]');
    if (deviceElement) {
        return deviceElement.getAttribute('data-device-id');
    }

    // Default device ID (you should set this properly)
    return 'device_001';
}

/**
 * Update last updated time
 */
function updateLastUpdatedTime() {
    const lastUpdatedElement = document.getElementById('lastUpdated');
    if (lastUpdatedElement) {
        const now = new Date();
        lastUpdatedElement.textContent = now.toLocaleString();
    }
}

/**
 * Show notification (simple implementation)
 */
function showNotification(message, type = 'info') {
    console.log(`[${type.toUpperCase()}]: ${message}`);
    // You can integrate with a toast library here
}

/**
 * Show alert message
 */
function showAlert(message, severity = 'info') {
    if (severity === 'critical' || severity === 'error') {
        alert(`Alert: ${message}`);
    } else {
        showNotification(message, severity);
    }
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (mqttClient) {
        mqttClient.disconnect();
    }
});
