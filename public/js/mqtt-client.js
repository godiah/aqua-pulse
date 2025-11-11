/**
 * HiveMQ MQTT WebSocket Client for AquaPulse
 *
 * This module handles WebSocket connection to HiveMQ broker
 * and manages real-time IoT data subscriptions
 */

class MQTTClient {
    constructor(config) {
        this.config = {
            hostname: config.hostname || 'broker.hivemq.com',
            port: config.port || 8000,
            path: config.path || '/mqtt',
            clientId: config.clientId || 'aquapulse_' + Math.random().toString(16).substr(2, 8),
            username: config.username || '',
            password: config.password || '',
            useSSL: config.useSSL || false,
            reconnectTimeout: 2000,
            keepAliveInterval: 60
        };

        this.client = null;
        this.isConnected = false;
        this.subscriptions = new Map();
        this.reconnectAttempts = 0;
        this.maxReconnectAttempts = 10;

        // Event callbacks
        this.onConnect = null;
        this.onDisconnect = null;
        this.onMessage = null;
        this.onError = null;
    }

    /**
     * Initialize connection to HiveMQ broker
     */
    connect() {
        try {
            // Create MQTT client using Paho
            this.client = new Paho.MQTT.Client(
                this.config.hostname,
                this.config.port,
                this.config.path,
                this.config.clientId
            );

            // Set callback handlers
            this.client.onConnectionLost = this.handleConnectionLost.bind(this);
            this.client.onMessageArrived = this.handleMessageArrived.bind(this);

            // Connection options
            const connectOptions = {
                timeout: 30,
                keepAliveInterval: this.config.keepAliveInterval,
                cleanSession: true,
                useSSL: this.config.useSSL,
                onSuccess: this.handleConnect.bind(this),
                onFailure: this.handleConnectionFailure.bind(this)
            };

            // Add credentials if provided
            if (this.config.username) {
                connectOptions.userName = this.config.username;
            }
            if (this.config.password) {
                connectOptions.password = this.config.password;
            }

            console.log('[MQTT] Connecting to broker:', this.config.hostname);
            this.client.connect(connectOptions);

        } catch (error) {
            console.error('[MQTT] Connection error:', error);
            if (this.onError) this.onError(error);
        }
    }

    /**
     * Handle successful connection
     */
    handleConnect() {
        console.log('[MQTT] Successfully connected to broker');
        this.isConnected = true;
        this.reconnectAttempts = 0;

        // Update UI connection status
        this.updateConnectionStatus(true);

        // Re-subscribe to previous topics
        this.resubscribeAll();

        if (this.onConnect) this.onConnect();
    }

    /**
     * Handle connection failure
     */
    handleConnectionFailure(error) {
        console.error('[MQTT] Connection failed:', error.errorMessage);
        this.isConnected = false;

        // Update UI connection status
        this.updateConnectionStatus(false);

        if (this.onError) this.onError(error);

        // Attempt reconnection
        this.attemptReconnect();
    }

    /**
     * Handle connection lost
     */
    handleConnectionLost(responseObject) {
        console.warn('[MQTT] Connection lost:', responseObject.errorMessage);
        this.isConnected = false;

        // Update UI connection status
        this.updateConnectionStatus(false);

        if (this.onDisconnect) this.onDisconnect(responseObject);

        // Attempt reconnection
        this.attemptReconnect();
    }

    /**
     * Handle incoming MQTT message
     */
    handleMessageArrived(message) {
        const topic = message.destinationName;
        const payload = message.payloadString;

        console.log('[MQTT] Message received:', { topic, payload });

        try {
            const data = JSON.parse(payload);

            // Process message based on topic
            this.processMessage(topic, data);

            // Call custom message handler
            if (this.onMessage) this.onMessage(topic, data);

        } catch (error) {
            console.error('[MQTT] Error parsing message:', error);
        }
    }

    /**
     * Process message based on topic type
     */
    processMessage(topic, data) {
        // Extract topic parts
        const parts = topic.split('/');
        const messageType = parts[parts.length - 1];
        const deviceId = parts[2];

        switch (messageType) {
            case 'water_level':
                this.handleWaterLevel(deviceId, data);
                break;
            case 'flow_rate':
                this.handleFlowRate(deviceId, data);
                break;
            case 'pump_status':
                this.handlePumpStatus(deviceId, data);
                break;
            case 'alerts':
                this.handleAlert(deviceId, data);
                break;
            default:
                console.warn('[MQTT] Unknown message type:', messageType);
        }
    }

    /**
     * Handle water level data
     */
    handleWaterLevel(deviceId, data) {
        // Update UI gauge
        if (data.level !== undefined) {
            this.updateWaterLevelGauge(data.level);
        }

        // Send to backend for persistence
        this.sendToBackend('/api/mqtt/water-level', {
            device_id: deviceId,
            level: data.level,
            volume: data.volume,
            capacity: data.capacity,
            timestamp: data.timestamp || new Date().toISOString()
        });
    }

    /**
     * Handle flow rate data
     */
    handleFlowRate(deviceId, data) {
        // Update UI
        if (data.flow_rate !== undefined) {
            this.updateFlowRateDisplay(data.flow_rate);
        }

        // Send to backend
        this.sendToBackend('/api/mqtt/flow-rate', {
            device_id: deviceId,
            flow_rate: data.flow_rate,
            timestamp: data.timestamp || new Date().toISOString()
        });
    }

    /**
     * Handle pump status updates
     */
    handlePumpStatus(deviceId, data) {
        // Update UI
        if (data.status !== undefined) {
            this.updatePumpStatusDisplay(data.status);
        }

        // Send to backend
        this.sendToBackend('/api/mqtt/pump-status', {
            device_id: deviceId,
            status: data.status,
            running_time: data.running_time,
            power_consumption: data.power_consumption,
            timestamp: data.timestamp || new Date().toISOString()
        });
    }

    /**
     * Handle alert messages
     */
    handleAlert(deviceId, data) {
        // Show alert notification
        this.showAlert(data.message, data.severity || 'info');

        // Send to backend
        this.sendToBackend('/api/mqtt/alert', {
            device_id: deviceId,
            message: data.message,
            severity: data.severity,
            timestamp: data.timestamp || new Date().toISOString()
        });
    }

    /**
     * Subscribe to a topic
     */
    subscribe(topic, qos = 0) {
        if (!this.isConnected) {
            console.warn('[MQTT] Cannot subscribe - not connected');
            return;
        }

        try {
            this.client.subscribe(topic, {
                qos: qos,
                onSuccess: () => {
                    console.log('[MQTT] Subscribed to:', topic);
                    this.subscriptions.set(topic, qos);
                },
                onFailure: (error) => {
                    console.error('[MQTT] Subscription failed:', error);
                }
            });
        } catch (error) {
            console.error('[MQTT] Subscribe error:', error);
        }
    }

    /**
     * Unsubscribe from a topic
     */
    unsubscribe(topic) {
        if (!this.isConnected) return;

        try {
            this.client.unsubscribe(topic, {
                onSuccess: () => {
                    console.log('[MQTT] Unsubscribed from:', topic);
                    this.subscriptions.delete(topic);
                }
            });
        } catch (error) {
            console.error('[MQTT] Unsubscribe error:', error);
        }
    }

    /**
     * Re-subscribe to all previous topics
     */
    resubscribeAll() {
        this.subscriptions.forEach((qos, topic) => {
            this.subscribe(topic, qos);
        });
    }

    /**
     * Publish message to a topic
     */
    publish(topic, payload, qos = 0, retained = false) {
        if (!this.isConnected) {
            console.warn('[MQTT] Cannot publish - not connected');
            return;
        }

        try {
            const message = new Paho.MQTT.Message(
                typeof payload === 'string' ? payload : JSON.stringify(payload)
            );
            message.destinationName = topic;
            message.qos = qos;
            message.retained = retained;

            this.client.send(message);
            console.log('[MQTT] Published to:', topic);
        } catch (error) {
            console.error('[MQTT] Publish error:', error);
        }
    }

    /**
     * Disconnect from broker
     */
    disconnect() {
        if (this.client && this.isConnected) {
            this.client.disconnect();
            this.isConnected = false;
            console.log('[MQTT] Disconnected from broker');
        }
    }

    /**
     * Attempt to reconnect with exponential backoff
     */
    attemptReconnect() {
        if (this.reconnectAttempts >= this.maxReconnectAttempts) {
            console.error('[MQTT] Max reconnection attempts reached');
            return;
        }

        this.reconnectAttempts++;
        const delay = Math.min(1000 * Math.pow(2, this.reconnectAttempts), 30000);

        console.log(`[MQTT] Reconnecting in ${delay}ms (attempt ${this.reconnectAttempts})`);

        setTimeout(() => {
            this.connect();
        }, delay);
    }

    /**
     * Send data to Laravel backend
     */
    async sendToBackend(endpoint, data) {
        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const result = await response.json();
            console.log('[MQTT] Data sent to backend:', result);
        } catch (error) {
            console.error('[MQTT] Backend error:', error);
        }
    }

    /**
     * Update connection status in UI
     */
    updateConnectionStatus(connected) {
        const statusElement = document.getElementById('mqtt-status');
        const indicatorElement = document.getElementById('mqtt-status-indicator');

        if (statusElement) {
            statusElement.textContent = connected ? 'Connected' : 'Disconnected';
            statusElement.className = connected ? 'text-xs text-green-600 font-semibold' : 'text-xs text-red-600';
        }

        if (indicatorElement) {
            indicatorElement.className = connected
                ? 'inline-block w-2 h-2 rounded-full bg-green-500 mr-2'
                : 'inline-block w-2 h-2 rounded-full bg-red-500 mr-2';
        }
    }

    /**
     * Update water level gauge
     */
    updateWaterLevelGauge(level) {
        const gaugeText = document.querySelector('.gauge-text');
        if (gaugeText) {
            gaugeText.textContent = level + '%';
        }

        const gaugeFill = document.querySelector('.gauge-fill');
        if (gaugeFill) {
            const dashOffset = 502 - (502 * level / 100);
            gaugeFill.style.strokeDashoffset = dashOffset;
        }
    }

    /**
     * Update flow rate display
     */
    updateFlowRateDisplay(flowRate) {
        const flowRateElement = document.querySelector('.flow-rate-value');
        if (flowRateElement) {
            flowRateElement.textContent = flowRate + ' L/min';
        }
    }

    /**
     * Update pump status display
     */
    updatePumpStatusDisplay(status) {
        const pumpToggle = document.getElementById('pumpToggle');
        if (pumpToggle) {
            pumpToggle.checked = status === 'on' || status === true;
        }
    }

    /**
     * Show alert notification
     */
    showAlert(message, severity) {
        // You can integrate with a toast/notification library
        console.log(`[ALERT ${severity.toUpperCase()}]:`, message);

        // Simple alert for now
        if (severity === 'critical' || severity === 'error') {
            alert(message);
        }
    }
}

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = MQTTClient;
}
