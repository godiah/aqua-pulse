<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    Admin Dashboard
                </h2>
                <p class="mt-1 text-sm text-gray-600">Welcome back! Here's what's happening with your system today.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    New User
                </a>
                <a href="{{ route('devices.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    New Device
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Overview Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Users</p>
                                <p class="mt-2 text-4xl font-bold">{{ $totalUsers }}</p>
                                <div class="mt-3 flex items-center text-blue-100 text-sm">
                                    <span class="font-medium">{{ $tenantUsers }}</span>
                                    <span class="mx-1">tenants</span>
                                    <span class="mx-2">•</span>
                                    <span class="font-medium">{{ $adminUsers }}</span>
                                    <span class="mx-1">admins</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-blue-700 bg-opacity-50 px-6 py-3">
                        <a href="{{ route('users.index') }}" class="text-white text-sm font-medium hover:text-blue-100 flex items-center">
                            View all users
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Total Devices Card -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-purple-100 text-sm font-medium uppercase tracking-wide">Total Devices</p>
                                <p class="mt-2 text-4xl font-bold">{{ $totalDevices }}</p>
                                <div class="mt-3 text-purple-100 text-sm">
                                    <span class="font-medium">All registered devices</span>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-purple-700 bg-opacity-50 px-6 py-3">
                        <a href="{{ route('devices.index') }}" class="text-white text-sm font-medium hover:text-purple-100 flex items-center">
                            View all devices
                            <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Online Devices Card -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Online Devices</p>
                                <p class="mt-2 text-4xl font-bold">{{ $activeDevices }}</p>
                                <div class="mt-3 text-green-100 text-sm">
                                    @if($totalDevices > 0)
                                        <span class="font-medium">{{ round(($activeDevices / $totalDevices) * 100, 1) }}%</span>
                                        <span class="mx-1">of total</span>
                                    @else
                                        <span>No devices yet</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-green-700 bg-opacity-50 px-6 py-3">
                        <span class="text-white text-sm font-medium flex items-center">
                            <span class="h-2 w-2 bg-green-300 rounded-full animate-pulse mr-2"></span>
                            Active connections
                        </span>
                    </div>
                </div>

                <!-- Offline Devices Card -->
                <div class="bg-gradient-to-br from-gray-500 to-gray-600 rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 text-white">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-gray-100 text-sm font-medium uppercase tracking-wide">Offline Devices</p>
                                <p class="mt-2 text-4xl font-bold">{{ $offlineDevices }}</p>
                                <div class="mt-3 text-gray-100 text-sm">
                                    @if($totalDevices > 0)
                                        <span class="font-medium">{{ round(($offlineDevices / $totalDevices) * 100, 1) }}%</span>
                                        <span class="mx-1">of total</span>
                                    @else
                                        <span>No devices yet</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="p-3 bg-white bg-opacity-20 rounded-lg">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0 0l-2.829-2.829m2.829 2.829L21 21M15.536 8.464a5 5 0 010 7.072m0 0l-2.829-2.829m-4.243 2.829a4.978 4.978 0 01-1.414-2.83m-1.414 5.658a9 9 0 01-2.167-9.238m7.824 2.167a1 1 0 111.414 1.414m-1.414-1.414L3 3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-700 bg-opacity-50 px-6 py-3">
                        <span class="text-white text-sm font-medium">Disconnected</span>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Recent Users -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Recent Users
                            </h3>
                            <a href="{{ route('users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">View all →</a>
                        </div>
                    </div>
                    <div class="p-6">
                        @forelse($recentUsers as $user)
                            <div class="flex items-center justify-between py-4 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50 px-4 rounded-lg transition">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br {{ $user->role === 'super_admin' ? 'from-purple-400 to-purple-600' : 'from-blue-400 to-blue-600' }} flex items-center justify-center text-white font-bold text-lg shadow-md">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        <div class="mt-1 flex items-center space-x-2">
                                            <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $user->role === 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                                            </span>
                                            @if($user->device)
                                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800 flex items-center">
                                                    <span class="h-1.5 w-1.5 bg-green-500 rounded-full mr-1"></span>
                                                    Device Linked
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('users.show', $user) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('users.edit', $user) }}" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="mt-4 text-gray-500">No users yet</p>
                                <a href="{{ route('users.create') }}" class="mt-2 inline-block text-blue-600 hover:text-blue-800 font-medium">Create your first user</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Quick Actions & Recent Devices -->
                <div class="space-y-6">

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                            <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Quick Actions
                            </h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <a href="{{ route('users.create') }}" class="flex items-center p-4 bg-gradient-to-r from-blue-50 to-blue-100 border border-blue-200 rounded-lg hover:shadow-md transition group">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-blue-600 flex items-center justify-center group-hover:scale-110 transition">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-gray-900">Add New User</p>
                                    <p class="text-xs text-gray-600">Create a new user account</p>
                                </div>
                            </a>

                            <a href="{{ route('devices.create') }}" class="flex items-center p-4 bg-gradient-to-r from-green-50 to-green-100 border border-green-200 rounded-lg hover:shadow-md transition group">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-green-600 flex items-center justify-center group-hover:scale-110 transition">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-gray-900">Add New Device</p>
                                    <p class="text-xs text-gray-600">Register a new device</p>
                                </div>
                            </a>

                            <a href="{{ route('users.index') }}" class="flex items-center p-4 bg-gradient-to-r from-purple-50 to-purple-100 border border-purple-200 rounded-lg hover:shadow-md transition group">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-purple-600 flex items-center justify-center group-hover:scale-110 transition">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-gray-900">Manage Users</p>
                                    <p class="text-xs text-gray-600">View and edit all users</p>
                                </div>
                            </a>

                            <a href="{{ route('devices.index') }}" class="flex items-center p-4 bg-gradient-to-r from-orange-50 to-orange-100 border border-orange-200 rounded-lg hover:shadow-md transition group">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-lg bg-orange-600 flex items-center justify-center group-hover:scale-110 transition">
                                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-bold text-gray-900">Manage Devices</p>
                                    <p class="text-xs text-gray-600">View and edit all devices</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <!-- Recent Devices -->
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                    </svg>
                                    Recent Devices
                                </h3>
                                <a href="{{ route('devices.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">View all →</a>
                            </div>
                        </div>
                        <div class="p-4">
                            @forelse($recentDevices as $device)
                                <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="h-10 w-10 rounded-lg {{ $device->status === 'online' ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                                                <svg class="h-6 w-6 {{ $device->status === 'online' ? 'text-green-600' : 'text-gray-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">Device #{{ $device->id }}</p>
                                            <p class="text-xs text-gray-500">{{ $device->tenant_id }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $device->status === 'online' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            <span class="h-1.5 w-1.5 rounded-full {{ $device->status === 'online' ? 'bg-green-500' : 'bg-gray-500' }} inline-block mr-1"></span>
                                            {{ ucfirst($device->status) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-500">No devices yet</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Logs Section -->
            <div class="mt-6 bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Recent Logs
                            @if($errorCount > 0)
                                <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    {{ $errorCount }} errors
                                </span>
                            @endif
                        </h3>
                        <a href="{{ route('logs.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-800">View all →</a>
                    </div>
                </div>
                <div class="p-6">
                    @forelse($recentLogs as $log)
                        <div class="flex items-start justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50 px-3 rounded-lg transition">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                        {{ $log->level === 'info' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $log->level === 'warning' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $log->level === 'error' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $log->level === 'critical' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        {{ ucfirst($log->level) }}
                                    </span>
                                    <a href="{{ route('devices.show', $log->device) }}" class="text-xs text-blue-600 hover:text-blue-900">
                                        Device #{{ $log->device_id }}
                                    </a>
                                    <span class="text-xs text-gray-500">{{ $log->logged_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-900">{{ Str::limit($log->message, 80) }}</p>
                            </div>
                            <a href="{{ route('logs.show', $log) }}" class="ml-4 text-blue-600 hover:text-blue-900 text-sm">
                                View
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p>No logs yet</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
