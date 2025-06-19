@extends('layouts.dashboard')

@section('title', 'AquaPulse - Dashboard')

@section('content')
    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6 sm:px-6 lg:px-8 pt-24">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Real-Time Monitoring -->
            <div class="card p-6">
                <h2 class="text-lg font-bold mb-4">Real-Time Monitoring</h2>

                <!-- Water Level Gauge -->
                <div class="gauge-container mb-6">
                    <svg viewBox="0 0 200 200">
                        <circle class="gauge-background" cx="100" cy="100" r="80" stroke-dasharray="502"
                            stroke-dashoffset="0"></circle>
                        <circle class="gauge-fill" cx="100" cy="100" r="80" stroke-dasharray="502"
                            stroke-dashoffset="125"></circle>
                        <circle class="gauge-center" cx="100" cy="100" r="60"></circle>
                        <text class="gauge-text" x="100" y="110" text-anchor="middle">75%</text>
                        <text class="gauge-label text-sm" x="100" y="130" text-anchor="middle">Tank Level</text>
                    </svg>
                </div>

                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs">Current Volume:</p>
                        <p class="text-lg font-bold">750 Liters</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs">Tank Capacity:</p>
                        <p class="text-lg font-bold">1000 Liters</p>
                    </div>
                </div>

                <!-- Inflow Indicator -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg flex items-center justify-between font-body">
                    <div class="flex items-center">
                        <span class="inflow-indicator inflow-active"></span>
                        <span class="font-medium text-sm">Inflow Status: <span
                                class="font-bold text-secondary">Active</span></span>
                    </div>
                    <div>
                        <span class="text-sm">Flow Rate: <span class="font-bold">12 L/min</span></span>
                    </div>
                </div>
            </div>

            <!-- Weekly Usage Analytics -->
            <div class="card p-6">
                <h2 class="text-lg font-bold mb-4">Weekly Usage Analytics</h2>
                <div class="h-64">
                    <canvas id="usageChart"></canvas>
                </div>
                <div class="grid grid-cols-3 gap-4 mt-6">
                    <div class="text-center p-3 bg-gray-50 rounded">
                        <p class="text-xs">Total Volume</p>
                        <p class="font-bold">4,350 L</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded">
                        <p class="text-xs">Daily Average</p>
                        <p class="font-bold">621 L</p>
                    </div>
                    <div class="text-center p-3 bg-gray-50 rounded">
                        <p class="text-xs">Peak Usage</p>
                        <p class="font-bold">830 L</p>
                    </div>
                </div>
            </div>

            <!-- Manual Pump Control -->
            <div class="card p-6">
                <h2 class="text-lg font-bold mb-4">Manual Pump Control</h2>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-sm">Current Status:</p>
                        <p class="text-lg font-bold">
                            <span class="inline-block px-3 py-1 rounded-full status-on">ON</span>
                        </p>
                    </div>
                    <div>
                        <label class="toggle-btn">
                            <input type="checkbox" checked id="pumpToggle">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm">Running Time:</span>
                        <span class="font-bold">01:23:45</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm">Power Consumption:</span>
                        <span class="font-bold">0.75 kWh</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm">Device Health:</span>
                        <div class="flex items-center">
                            <span class="inline-block w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                            <span class="font-bold">Online</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button class="w-full btn-primary py-3 rounded-lg font-bold text-center">
                        Force Pump Stop
                    </button>
                </div>
            </div>
        </div>

        <!-- Automated Pump Scheduling -->
        <div class="card p-6 mt-6">
            <h2 class="text-xl font-bold mb-4">Automated Pump Scheduling</h2>

            <!-- Schedule Form -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-medium mb-3">Create New Schedule</h3>

                <!-- Days Selection -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Select Days:</label>
                    <div class="flex flex-wrap">
                        <div class="schedule-day" data-day="mon">Mon</div>
                        <div class="schedule-day selected" data-day="tue">Tue</div>
                        <div class="schedule-day selected" data-day="wed">Wed</div>
                        <div class="schedule-day" data-day="thu">Thu</div>
                        <div class="schedule-day selected" data-day="fri">Fri</div>
                        <div class="schedule-day" data-day="sat">Sat</div>
                        <div class="schedule-day" data-day="sun">Sun</div>
                    </div>
                </div>

                <!-- Time Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium mb-2">Start Time:</label>
                        <input type="time" class="time-picker w-full" value="06:30">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">End Time:</label>
                        <input type="time" class="time-picker w-full" value="07:30">
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-2">
                    <button class="px-4 py-2 border border-gray-300 rounded-lg">Cancel</button>
                    <button class="btn-primary px-6 py-2 rounded-lg">Save Schedule</button>
                </div>
            </div>

            <!-- Schedule List -->
            <div>
                <h3 class="text-lg font-medium mb-3">Upcoming Schedules</h3>
                <div class="overflow-x-auto">
                    <table class="w-full table-auto">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left">Days</th>
                                <th class="px-4 py-2 text-left">Start Time</th>
                                <th class="px-4 py-2 text-left">End Time</th>
                                <th class="px-4 py-2 text-left">Duration</th>
                                <th class="px-4 py-2 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b">
                                <td class="px-4 py-3">Tue, Wed, Fri</td>
                                <td class="px-4 py-3">06:30 AM</td>
                                <td class="px-4 py-3">07:30 AM</td>
                                <td class="px-4 py-3">1h 00m</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="openScheduleModal()"
                                            class="p-1 text-blue-600 hover:text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="border-b">
                                <td class="px-4 py-3">Mon, Thu</td>
                                <td class="px-4 py-3">08:00 AM</td>
                                <td class="px-4 py-3">09:15 AM</td>
                                <td class="px-4 py-3">1h 15m</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="openScheduleModal()"
                                            class="p-1 text-blue-600 hover:text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-3">Sat, Sun</td>
                                <td class="px-4 py-3">07:30 AM</td>
                                <td class="px-4 py-3">10:00 AM</td>
                                <td class="px-4 py-3">2h 30m</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center space-x-2">
                                        <button onclick="openScheduleModal()"
                                            class="p-1 text-blue-600 hover:text-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button class="p-1 text-red-600 hover:text-red-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('partials.schedule-modal')
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Chart & Pump Switch JavaScript -->
    <script>
        // Initialize the usage chart
        document.addEventListener('DOMContentLoaded', function() {
            // Weekly Usage Chart
            const ctx = document.getElementById('usageChart').getContext('2d');
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Water Usage (Liters)',
                        data: [520, 630, 750, 580, 830, 450, 590],
                        backgroundColor: '#4dd0e1',
                        borderColor: '#00796b',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Liters'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Day'
                            }
                        }
                    }
                }
            });

            // Toggle Pump Status
            const pumpToggle = document.getElementById('pumpToggle');
            pumpToggle.addEventListener('change', function() {
                const statusIndicator = document.querySelector('.status-on');
                if (this.checked) {
                    statusIndicator.textContent = 'ON';
                    statusIndicator.classList.remove('status-off');
                    statusIndicator.classList.add('status-on');
                } else {
                    statusIndicator.textContent = 'OFF';
                    statusIndicator.classList.remove('status-on');
                    statusIndicator.classList.add('status-off');
                }
            });

            // Schedule Day Selection
            const scheduleDays = document.querySelectorAll('.schedule-day');
            scheduleDays.forEach(day => {
                day.addEventListener('click', function() {
                    this.classList.toggle('selected');
                });
            });
        });
    </script>
@endsection
