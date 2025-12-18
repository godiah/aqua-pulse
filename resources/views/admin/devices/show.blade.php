<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Device Details') }} - #{{ $device->id }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('devices.edit', $device) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Device
                </a>
                <a href="{{ route('devices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Devices
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Device Information Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Device Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Device ID</label>
                            <p class="mt-1 text-lg text-gray-900">#{{ $device->id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Status</label>
                            <p class="mt-1">
                                <span class="inline-flex items-center px-3 py-1 text-sm leading-5 font-semibold rounded-full
                                    {{ $device->status === 'online' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    <span class="h-2 w-2 mr-2 rounded-full {{ $device->status === 'online' ? 'bg-green-400' : 'bg-gray-400' }}"></span>
                                    {{ ucfirst($device->status) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tenant ID</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $device->tenant_id }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Inflow Status</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $device->inflow_status ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Last Seen</label>
                            <p class="mt-1 text-lg text-gray-900">
                                @if($device->last_seen)
                                    {{ $device->last_seen->diffForHumans() }}
                                    <span class="text-sm text-gray-500">({{ $device->last_seen->format('M d, Y H:i') }})</span>
                                @else
                                    Never
                                @endif
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Created</label>
                            <p class="mt-1 text-lg text-gray-900">{{ $device->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Linked User Information Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Linked User</h3>
                    @if($device->user)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Name</label>
                                <p class="mt-1 text-lg text-gray-900">
                                    <a href="{{ route('users.show', $device->user) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $device->user->name }}
                                    </a>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $device->user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Role</label>
                                <p class="mt-1">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full
                                        {{ $device->user->role === 'super_admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $device->user->role)) }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500">User Tenant ID</label>
                                <p class="mt-1 text-lg text-gray-900">{{ $device->user->tenant_id ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('users.edit', $device->user) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                Edit User →
                            </a>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <p class="mt-2 text-gray-500">No user linked to this device</p>
                            <p class="mt-1 text-sm text-gray-400">Users can link to this device through their profile edit page</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Device Statistics Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-600">Device Age</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $device->created_at->diffForHumans(null, true) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-600">Connection Status</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $device->status === 'online' ? 'Connected' : 'Disconnected' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="flex items-center">
                                <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-600">User Link</p>
                                    <p class="text-lg font-semibold text-gray-900">
                                        {{ $device->user ? 'Linked' : 'Unlinked' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Logs Card -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mt-6">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Logs</h3>
                        <a href="{{ route('logs.index', ['device_id' => $device->id]) }}" class="text-sm text-blue-600 hover:text-blue-900">
                            View All Logs →
                        </a>
                    </div>
                    @forelse($recentLogs as $log)
                        <div class="flex items-start justify-between py-3 {{ !$loop->last ? 'border-b border-gray-100' : '' }}">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                        {{ $log->level === 'info' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $log->level === 'warning' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $log->level === 'error' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $log->level === 'critical' ? 'bg-purple-100 text-purple-800' : '' }}">
                                        {{ ucfirst($log->level) }}
                                    </span>
                                    <span class="text-xs text-gray-500">{{ $log->logged_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-gray-900">{{ $log->message }}</p>
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
                            <p>No logs yet for this device</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
