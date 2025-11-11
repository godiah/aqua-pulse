# HiveMQ WebSocket Integration Documentation

## Overview
This document tracks the implementation of HiveMQ MQTT broker integration using WebSockets for real-time IoT data in AquaPulse.

## Architecture

### Communication Flow
```
IoT Device → HiveMQ Broker → WebSocket → JavaScript Client → Laravel Backend → Database
```

## Implementation Steps

### 1. HiveMQ Configuration
**Date:** 2025-10-02

#### Broker Details
- **Broker URL:** (To be configured)
- **WebSocket Port:** Usually 8000 or 8884 (WSS)
- **Protocol:** MQTT over WebSocket (ws:// or wss://)

#### Topics Structure
- `/aquapulse/device/{device_id}/water_level` - Water level readings
- `/aquapulse/device/{device_id}/flow_rate` - Flow rate data
- `/aquapulse/device/{device_id}/pump_status` - Pump on/off status
- `/aquapulse/device/{device_id}/alerts` - Alert messages

### 2. Frontend Setup (JavaScript MQTT Client)

#### Required Library
- **Paho MQTT JavaScript Client** or **MQTT.js**
- Loaded via CDN or npm

#### Connection Parameters
```javascript
{
  hostname: 'broker.hivemq.com',
  port: 8000,
  path: '/mqtt',
  clientId: 'aquapulse_' + Math.random().toString(16).substr(2, 8),
  username: 'your_username',
  password: 'your_password',
  useSSL: true
}
```

### 3. Backend Integration

#### Database Tables Affected
- `water_levels` - Store incoming water level data
- `devices` - Device status updates
- `schedules` - Triggered schedule actions

#### API Endpoints to Create
- `POST /api/mqtt/water-level` - Receive water level data
- `POST /api/mqtt/pump-status` - Update pump status
- `POST /api/mqtt/flow-rate` - Store flow rate readings

### 4. Security Considerations

#### Authentication
- [ ] Use HiveMQ credentials (username/password)
- [ ] Consider JWT tokens for WebSocket authentication
- [ ] Implement SSL/TLS (wss://) in production

#### Data Validation
- [ ] Validate incoming MQTT messages
- [ ] Sanitize device IDs
- [ ] Verify message format and payload

### 5. Error Handling

#### Connection Issues
- Implement reconnection logic with exponential backoff
- Show connection status in UI
- Log connection errors

#### Message Handling
- Validate message payload before processing
- Handle malformed messages gracefully
- Implement message queuing for offline scenarios

## Configuration Files

### Environment Variables (.env)
```bash
HIVEMQ_BROKER_URL=broker.hivemq.com
HIVEMQ_WS_PORT=8000
HIVEMQ_USERNAME=your_username
HIVEMQ_PASSWORD=your_password
HIVEMQ_USE_SSL=true
```

## Testing Checklist

- [ ] Test WebSocket connection to HiveMQ
- [ ] Verify message subscription
- [ ] Test message publishing
- [ ] Validate data persistence to database
- [ ] Test reconnection on network failure
- [ ] Verify SSL/TLS connection

## Implementation Complete ✅

### Files Created

#### 1. Frontend (JavaScript)
- **`/public/js/mqtt-client.js`** - Main MQTT WebSocket client class
- **`/public/js/mqtt-init.js`** - Dashboard initialization script

#### 2. Backend (Laravel)
- **`/app/Services/MqttService.php`** - Service class for handling MQTT messages
- **`/app/Http/Controllers/Api/MqttController.php`** - API controller for MQTT endpoints
- **`/routes/api.php`** - API routes for MQTT data

#### 3. Configuration
- **`/config/hivemq.php`** - HiveMQ configuration file
- **`.env`** - Environment variables added:
  ```
  HIVEMQ_BROKER_URL=broker.hivemq.com
  HIVEMQ_WS_PORT=8000
  HIVEMQ_WS_PATH=/mqtt
  HIVEMQ_USERNAME=
  HIVEMQ_PASSWORD=
  HIVEMQ_USE_SSL=false
  HIVEMQ_CLIENT_ID_PREFIX=aquapulse
  ```

#### 4. UI Updates
- Added Paho MQTT library to dashboard layout
- Added MQTT connection status indicator in header
- Integrated MQTT scripts in dashboard

### How It Works

1. **Connection Flow:**
   - Dashboard loads → MQTT client initializes
   - Connects to HiveMQ broker via WebSocket
   - Subscribes to device topics
   - Shows connection status in header

2. **Data Flow:**
   ```
   IoT Device → HiveMQ → WebSocket → JavaScript Client
                                    ↓
                              Update UI (real-time)
                                    ↓
                              Send to Laravel API
                                    ↓
                              Process & Store in DB
   ```

3. **Message Topics:**
   - Water Level: `/aquapulse/device/{device_id}/water_level`
   - Flow Rate: `/aquapulse/device/{device_id}/flow_rate`
   - Pump Status: `/aquapulse/device/{device_id}/pump_status`
   - Alerts: `/aquapulse/device/{device_id}/alerts`
   - Control: `/aquapulse/device/{device_id}/control`

### Next Steps

1. **Configure HiveMQ Credentials:**
   - Update `.env` file with your HiveMQ broker details
   - If using HiveMQ Cloud, use your cluster URL
   - Add username and password if authentication is enabled
   - Set `HIVEMQ_USE_SSL=true` for production

2. **Update Device Table:**
   - Ensure `devices` table has these columns:
     - `device_id` (string) - Unique device identifier
     - `current_level` (float)
     - `flow_rate` (float)
     - `pump_status` (string)
     - `last_reading_at` (timestamp)
     - `status` (string) - online/offline

3. **Set Device ID:**
   - In dashboard, add device ID to a data attribute:
     ```html
     <div data-device-id="your_device_id">
     ```
   - Or implement `getDeviceId()` function in `mqtt-init.js`

4. **Test Connection:**
   - Open browser console
   - Check for MQTT connection logs
   - Verify WebSocket connection in Network tab
   - Test with MQTT simulator or actual IoT device

5. **IoT Device Setup:**
   - Configure your IoT device to publish to HiveMQ
   - Use the same topic structure
   - Send JSON payload format:
     ```json
     {
       "level": 75,
       "volume": 750,
       "capacity": 1000,
       "timestamp": "2025-10-02T10:30:00Z"
     }
     ```

### Testing with MQTT Client

You can test the setup using MQTT.fx or mosquitto_pub:

```bash
# Test water level
mosquitto_pub -h broker.hivemq.com -p 1883 \
  -t "/aquapulse/device/device_001/water_level" \
  -m '{"level":75,"volume":750,"capacity":1000}'

# Test flow rate
mosquitto_pub -h broker.hivemq.com -p 1883 \
  -t "/aquapulse/device/device_001/flow_rate" \
  -m '{"flow_rate":12}'

# Test pump status
mosquitto_pub -h broker.hivemq.com -p 1883 \
  -t "/aquapulse/device/device_001/pump_status" \
  -m '{"status":"on","running_time":"01:23:45","power_consumption":0.75}'
```

### Troubleshooting

**Connection Issues:**
- Check browser console for errors
- Verify HiveMQ broker URL and port
- Check if WebSocket port is accessible (firewall)
- Verify credentials if authentication is enabled

**Messages Not Received:**
- Check topic subscription in console logs
- Verify device is publishing to correct topics
- Check QoS settings match
- Verify message format is valid JSON

**Data Not Saving:**
- Check API endpoint responses in Network tab
- Verify CSRF token is present
- Check Laravel logs: `storage/logs/laravel.log`
- Verify device exists in database

### Security Recommendations for Production

1. **Use SSL/TLS (WSS):**
   - Set `HIVEMQ_USE_SSL=true`
   - Use secure WebSocket (wss://)

2. **Authentication:**
   - Enable HiveMQ authentication
   - Use strong credentials
   - Store credentials securely

3. **API Security:**
   - Add authentication to API routes
   - Validate device ownership
   - Implement rate limiting
   - Sanitize all inputs

4. **CORS Configuration:**
   - Configure allowed origins
   - Restrict to your domain only

## Notes

### Session 1: Infrastructure Setup (2025-10-02)
- ✅ Created documentation structure
- ✅ Defined topic hierarchy
- ✅ Outlined security requirements
- ✅ Implemented complete WebSocket infrastructure
- ✅ Created MQTT client library
- ✅ Set up Laravel backend services
- ✅ Added API endpoints
- ✅ Integrated with dashboard UI
- ✅ Added connection status indicator

### Ready for Testing
All infrastructure is now in place. Configure your HiveMQ credentials and device settings to start receiving real-time data.

---

## How to Connect to Your HiveMQ Broker

### Connection Configuration

Your `.env` file is already configured for the public HiveMQ broker:

```bash
HIVEMQ_BROKER_URL=broker.hivemq.com
HIVEMQ_WS_PORT=8000
HIVEMQ_WS_PATH=/mqtt
HIVEMQ_USERNAME=
HIVEMQ_PASSWORD=
HIVEMQ_USE_SSL=false
HIVEMQ_CLIENT_ID_PREFIX=aquapulse
```

**For HiveMQ Cloud (Production):**
Update your `.env` with your cluster credentials:

```bash
HIVEMQ_BROKER_URL=your-cluster.s1.eu.hivemq.cloud
HIVEMQ_WS_PORT=8884
HIVEMQ_WS_PATH=/mqtt
HIVEMQ_USERNAME=your_username
HIVEMQ_PASSWORD=your_password
HIVEMQ_USE_SSL=true
```

### Testing the Connection

#### 1. Start Laravel Server

```bash
php artisan serve
```

Server will run at http://127.0.0.1:8000

#### 2. Open Dashboard and Check Console

1. Navigate to: http://127.0.0.1:8000/dashboard
2. Open browser DevTools (F12) → Console tab
3. Look for connection logs:

```
[MQTT Init] Connecting with config: {hostname: "broker.hivemq.com", ...}
[MQTT] Connecting to broker: broker.hivemq.com
[MQTT] Successfully connected to broker
[MQTT] Subscribed to: /aquapulse/device/device_001/water_level
```

#### 3. Check Connection Status in UI

In the dashboard header, you should see:
- **Green dot + "Connected"** = Success ✓
- **Red dot + "Disconnected"** = Connection issue

### Simulating IoT Device Messages

#### Using mosquitto_pub (Command Line)

**Test Water Level:**
```bash
mosquitto_pub -h broker.hivemq.com -p 1883 \
  -t "/aquapulse/device/device_001/water_level" \
  -m '{"level":75,"volume":750,"capacity":1000}'
```

**Test Flow Rate:**
```bash
mosquitto_pub -h broker.hivemq.com -p 1883 \
  -t "/aquapulse/device/device_001/flow_rate" \
  -m '{"flow_rate":12.5}'
```

**Test Pump Status:**
```bash
mosquitto_pub -h broker.hivemq.com -p 1883 \
  -t "/aquapulse/device/device_001/pump_status" \
  -m '{"status":"on","running_time":"01:23:45","power_consumption":0.75}'
```

**Test Alert:**
```bash
mosquitto_pub -h broker.hivemq.com -p 1883 \
  -t "/aquapulse/device/device_001/alerts" \
  -m '{"message":"Water level critically low!","severity":"warning"}'
```

#### Using MQTT Client GUI

**MQTT.fx or MQTTX:**
1. Download and install MQTT.fx or MQTTX
2. Create new connection:
   - Broker Address: `broker.hivemq.com`
   - Port: `1883`
   - Client ID: Any unique ID
3. Connect and publish to topics above with JSON payloads

### What Should Happen When Testing

**In Browser Console:**
```
[MQTT] Message received: {topic: "...", payload: "..."}
Dashboard: Received message {topic: "...", data: {...}}
[MQTT] Data sent to backend: {success: true}
```

**In Dashboard UI:**
- Water level gauge updates in real-time
- Flow rate display changes
- Pump status indicator updates
- Alerts show up

**In Laravel Backend:**
- Check `storage/logs/laravel.log` for processing logs:
```
[timestamp] local.INFO: MQTT: Water level processed {"device_id":"device_001","level":75}
```

### Troubleshooting Connection Issues

**Connection Failed:**
- ❌ Port 8000 (WebSocket) blocked by firewall
- ❌ Incorrect broker URL or port
- ❌ SSL/TLS mismatch (using `ws://` with SSL enabled)
- ✓ Solution: Check firewall settings and verify `.env` configuration

**Messages Not Received:**
- ❌ Wrong device_id (currently hardcoded as `device_001`)
- ❌ Topic names don't match exactly (case-sensitive)
- ❌ Invalid JSON payload
- ✓ Solution: Verify topic structure and JSON format

**Browser Shows "Disconnected":**
- ❌ WebSocket connection failed
- ❌ CORS issues
- ❌ Paho MQTT library not loaded
- ✓ Solution: Check browser console for errors, verify CDN is accessible

**Data Not Saving to Database:**
- ❌ CSRF token missing
- ❌ API routes not registered
- ❌ Models missing fillable properties
- ✓ Solution: Check Network tab in DevTools, verify API responses

### Expected Log Outputs

**Successful Connection:**
```
[MQTT Init] Connecting with config: {hostname: "broker.hivemq.com", port: 8000, path: "/mqtt", useSSL: false}
[MQTT] Connecting to broker: broker.hivemq.com
[MQTT] Successfully connected to broker
[MQTT] Subscribed to: /aquapulse/device/device_001/water_level
[MQTT] Subscribed to: /aquapulse/device/device_001/flow_rate
[MQTT] Subscribed to: /aquapulse/device/device_001/pump_status
[MQTT] Subscribed to: /aquapulse/device/device_001/alerts
Dashboard: MQTT connected successfully
```

**Message Received:**
```
[MQTT] Message received: {topic: "/aquapulse/device/device_001/water_level", payload: "{\"level\":75,\"volume\":750}"}
Dashboard: Received message {topic: "/aquapulse/device/device_001/water_level", data: {level: 75, volume: 750}}
[MQTT] Data sent to backend: {success: true, message: "Water level data processed successfully"}
```

### Network Traffic Analysis

**WebSocket Connection:**
- Protocol: `ws://` or `wss://`
- URL: `ws://broker.hivemq.com:8000/mqtt`
- Status: `101 Switching Protocols`

**API Calls:**
- `POST /api/mqtt/water-level` → 200 OK
- `POST /api/mqtt/flow-rate` → 200 OK
- `POST /api/mqtt/pump-status` → 200 OK
- `POST /api/mqtt/alert` → 200 OK

---

## Common Issues and Fixes

### Issue 1: "Connection Failed" Error

**Symptoms:**
- Red dot in header showing "Disconnected"
- Console error: `[MQTT] Connection failed: [error message]`
- WebSocket connection shows "failed" in Network tab

**Possible Causes & Solutions:**

**A. Port 8000 Blocked by Firewall**
```bash
# Test if port is accessible
nc -zv broker.hivemq.com 8000
# or
telnet broker.hivemq.com 8000
```
- ✓ If fails: Check firewall, try different network, or use cloud HiveMQ with port 8884

**B. Wrong WebSocket Port**
- Public HiveMQ: Use port `8000` (WS) or `8884` (WSS)
- Check `.env`: `HIVEMQ_WS_PORT=8000`
- For SSL: `HIVEMQ_WS_PORT=8884` and `HIVEMQ_USE_SSL=true`

**C. Mixed Content (HTTP page with WSS)**
```bash
# If your site uses HTTPS, you must use WSS
HIVEMQ_USE_SSL=true
HIVEMQ_WS_PORT=8884
```

**D. CORS or Proxy Issues**
- Some corporate networks block WebSocket connections
- Try from different network (mobile hotspot, home WiFi)
- Use VPN if corporate proxy is blocking

---

### Issue 2: Connected But No Messages Received

**Symptoms:**
- Green dot showing "Connected"
- No `[MQTT] Message received` logs when publishing
- Subscriptions appear successful

**Possible Causes & Solutions:**

**A. Wrong Device ID**
```javascript
// In browser console, check what device_id is being used:
console.log(getDeviceId()); // Should output: device_001

// If wrong, add to your dashboard blade:
<div data-device-id="your_actual_device_id">
```

**B. Topic Mismatch**
```bash
# Ensure topic structure matches EXACTLY (case-sensitive):
# Publishing to:
/aquapulse/device/device_001/water_level  ✓ Correct

# NOT:
/AquaPulse/device/device_001/water_level  ✗ Wrong case
/aquapulse/device/Device_001/water_level  ✗ Wrong case
/aquapulse/devices/device_001/water_level ✗ "devices" (plural)
```

**C. Invalid JSON Payload**
```bash
# This will fail (not valid JSON):
mosquitto_pub -t "/aquapulse/device/device_001/water_level" -m "level:75"

# This works:
mosquitto_pub -t "/aquapulse/device/device_001/water_level" -m '{"level":75}'
```

**D. QoS Mismatch**
```javascript
// Try changing QoS in config/hivemq.php:
'qos' => 1,  // Instead of 0
```

---

### Issue 3: Messages Received But UI Not Updating

**Symptoms:**
- Console shows `[MQTT] Message received`
- Dashboard UI elements don't change (gauge, status, etc.)

**Possible Causes & Solutions:**

**A. Missing UI Elements**
```javascript
// In browser console, check if elements exist:
document.querySelector('.gauge-text')      // Should not be null
document.querySelector('.gauge-fill')      // Should not be null
document.getElementById('pumpToggle')      // Should not be null

// If null, elements are missing from dashboard.blade.php
```

**B. JavaScript Errors**
- Open DevTools → Console
- Look for red error messages
- Common: `Cannot read property 'textContent' of null`
- Fix: Add null checks in mqtt-client.js

**C. Wrong Data Format**
```javascript
// Check what data is received:
// Expected: {"level":75}
// If different format, update handleWaterLevel() function
```

---

### Issue 4: Backend API Errors (422, 500)

**Symptoms:**
- Console shows `[MQTT] Backend error: HTTP error! status: 422`
- Network tab shows red API calls
- Laravel log shows validation errors

**Possible Causes & Solutions:**

**A. CSRF Token Missing**
```html
<!-- Verify this exists in dashboard.blade.php <head>: -->
<meta name="csrf-token" content="{{ csrf_token() }}">
```

**B. Validation Errors (422)**
```bash
# Check Laravel logs:
tail -f storage/logs/laravel.log

# Common issues:
# - Missing required fields (device_id, level, etc.)
# - Wrong data types (string instead of number)
# - Out of range values (level > 100)
```

**C. Database Errors (500)**
```bash
# Device not found:
# Solution: Create device in database first
php artisan tinker
>>> App\Models\Device::create(['device_id' => 'device_001', 'tenant_id' => 1]);

# Or update MqttService to auto-create devices
```

**D. Missing Fillable Properties**
```php
// If error: "Add [column_name] to fillable property"
// Update app/Models/Device.php:
protected $fillable = [
    'device_id', 'tenant_id', 'status', 'current_level',
    'flow_rate', 'pump_status', 'last_reading_at'
];
```

---

### Issue 5: Reconnection Loop

**Symptoms:**
- Console shows repeated connection attempts
- Status flickers between connected/disconnected
- Eventually stops trying after 10 attempts

**Possible Causes & Solutions:**

**A. Unstable Network**
```javascript
// Increase reconnection attempts in mqtt-client.js:
this.maxReconnectAttempts = 50; // Instead of 10
```

**B. Keep-Alive Issues**
```php
// Increase keep-alive interval in config/hivemq.php:
'keep_alive_interval' => 120, // Instead of 60 seconds
```

**C. Broker Limits**
- HiveMQ Free tier has connection limits
- Solution: Use HiveMQ Cloud paid tier or setup own broker

---

### Issue 6: Paho MQTT Library Not Loading

**Symptoms:**
- Console error: `Paho is not defined`
- Error: `MQTTClient is not a constructor`

**Possible Causes & Solutions:**

**A. CDN Link Broken**
```html
<!-- Verify CDN link in resources/views/layouts/dashboard.blade.php: -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js"></script>

<!-- If blocked, try alternative CDN: -->
<script src="https://unpkg.com/paho-mqtt@1.1.0/paho-mqtt.js"></script>
```

**B. Script Loading Order**
```html
<!-- Correct order: -->
1. Paho MQTT library (from CDN)
2. mqtt-client.js (your client class)
3. mqtt-init.js (initialization)

<!-- If wrong order, MQTT won't work -->
```

**C. Offline/No Internet**
- CDN requires internet connection
- Solution: Download paho-mqtt.js locally to public/js/

---

### Issue 7: HTTPS Site with WS (Not WSS)

**Symptoms:**
- Console error: `Mixed Content: The page was loaded over HTTPS, but attempted to connect to insecure WebSocket endpoint`
- Connection fails on production

**Solution:**
```bash
# Update .env for production:
HIVEMQ_USE_SSL=true
HIVEMQ_WS_PORT=8884  # Secure WebSocket port

# Restart server
php artisan config:clear
```

---

### Issue 8: Data Not Persisting to Database

**Symptoms:**
- Console shows successful backend response
- But data not in database
- No errors in Laravel log

**Possible Causes & Solutions:**

**A. Database Tables Not Migrated**
```bash
# Run migrations:
php artisan migrate

# Check if tables exist:
php artisan tinker
>>> Schema::hasTable('devices')
>>> Schema::hasTable('water_levels')
```

**B. Transaction Not Committing**
```php
// Check if database connection is working:
php artisan tinker
>>> DB::connection()->getPdo();
>>> DB::table('devices')->count();
```

**C. Model Relationships Issues**
```bash
# Check Laravel log for relationship errors
tail -f storage/logs/laravel.log
```

---

### Issue 9: High Latency / Delayed Updates

**Symptoms:**
- Messages take 5-10 seconds to appear
- UI updates lag behind actual device state

**Possible Causes & Solutions:**

**A. Network Latency**
```bash
# Check latency to broker:
ping broker.hivemq.com

# If high (>200ms), consider:
# - Using closer HiveMQ Cloud region
# - Local MQTT broker (Mosquitto)
```

**B. Backend Processing Slow**
```php
// Optimize MqttService.php:
// - Remove unnecessary database queries
// - Use queue for heavy processing
// - Add database indexes
```

**C. Too Many Console Logs**
```javascript
// Comment out verbose logging in production:
// console.log('[MQTT] Message received:', ...);
```

---

### Issue 10: Multiple Connections from Same Client

**Symptoms:**
- Multiple subscriptions to same topic
- Duplicate messages received
- Connection conflicts

**Solution:**
```javascript
// Ensure only one MQTT client instance:
if (window.mqttClient && window.mqttClient.isConnected) {
    console.log('MQTT already connected');
    return;
}

// Store globally:
window.mqttClient = new MQTTClient(config);
```

---

### Debugging Checklist

When something doesn't work, check in this order:

**1. Browser Console (F12)**
- [ ] Any JavaScript errors (red)?
- [ ] MQTT connection logs present?
- [ ] Message received logs showing?

**2. Network Tab**
- [ ] WebSocket connection successful (101 status)?
- [ ] API calls returning 200 OK?
- [ ] CSRF token present in requests?

**3. Laravel Logs**
```bash
tail -f storage/logs/laravel.log
```
- [ ] MQTT processing logs present?
- [ ] Any validation errors?
- [ ] Database query errors?

**4. Environment Configuration**
```bash
cat .env | grep HIVEMQ
```
- [ ] Broker URL correct?
- [ ] Port correct (8000 for WS, 8884 for WSS)?
- [ ] SSL setting matches port?

**5. Database State**
```bash
php artisan tinker
>>> App\Models\Device::where('device_id', 'device_001')->first();
```
- [ ] Device exists?
- [ ] Tenant_id set correctly?

**6. MQTT Broker**
```bash
# Test broker connectivity:
mosquitto_sub -h broker.hivemq.com -p 1883 -t "#" -v
# Should show all messages on broker
```

---

### Getting Additional Help

**Enable Debug Mode:**
```bash
# In .env:
APP_DEBUG=true
LOG_LEVEL=debug

# In config/hivemq.php, add:
'debug' => true,
```

**Collect Debug Information:**
```bash
# System info:
php artisan about

# Check routes:
php artisan route:list | grep mqtt

# Test database:
php artisan migrate:status
```

**Useful Tools:**
- **MQTT Explorer**: GUI for testing MQTT connections
- **Browser DevTools**: Network and Console tabs
- **Postman**: Test API endpoints directly
- **Laravel Telescope**: Monitor requests and logs

---

## References
- [HiveMQ WebSocket Documentation](https://www.hivemq.com/blog/mqtt-client-library-encyclopedia-paho-js/)
- [Paho JavaScript Client](https://www.eclipse.org/paho/index.php?page=clients/js/index.php)
- [MQTT.js Documentation](https://github.com/mqttjs/MQTT.js)
- [HiveMQ Cloud Console](https://console.hivemq.cloud/)
- [Mosquitto MQTT Tools](https://mosquitto.org/download/)
