<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Device') }}: #{{ $device->id }}
            </h2>
            <a href="{{ route('devices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Devices
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('devices.update', $device) }}">
                        @csrf
                        @method('PUT')

                        <!-- Tenant ID -->
                        <div class="mb-4">
                            <label for="tenant_id" class="block font-medium text-sm text-gray-700">Tenant ID</label>
                            <input id="tenant_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" type="text" name="tenant_id" value="{{ old('tenant_id', $device->tenant_id) }}" required autofocus />
                            @error('tenant_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">Unique identifier for the tenant that owns this device</p>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <select id="status" name="status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                <option value="online" {{ old('status', $device->status) === 'online' ? 'selected' : '' }}>Online</option>
                                <option value="offline" {{ old('status', $device->status) === 'offline' ? 'selected' : '' }}>Offline</option>
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">Changing to "online" will update last_seen timestamp</p>
                        </div>

                        <!-- Inflow Status -->
                        <div class="mb-6">
                            <label for="inflow_status" class="block font-medium text-sm text-gray-700">
                                Inflow Status
                                <span class="text-gray-500 text-xs">(optional)</span>
                            </label>
                            <input id="inflow_status" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" type="text" name="inflow_status" value="{{ old('inflow_status', $device->inflow_status) }}" />
                            @error('inflow_status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-gray-500 text-xs mt-1">Current water inflow status of the device</p>
                        </div>

                        <!-- Device Info -->
                        <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-700 mb-2">Device Information</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-500">Device ID:</span>
                                    <span class="font-medium text-gray-900">#{{ $device->id }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Created:</span>
                                    <span class="font-medium text-gray-900">{{ $device->created_at->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Last Seen:</span>
                                    <span class="font-medium text-gray-900">
                                        @if($device->last_seen)
                                            {{ $device->last_seen->diffForHumans() }}
                                        @else
                                            Never
                                        @endif
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Linked User:</span>
                                    <span class="font-medium text-gray-900">
                                        @if($device->user)
                                            <a href="{{ route('users.show', $device->user) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $device->user->name }}
                                            </a>
                                        @else
                                            No user linked
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('devices.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Update Device
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danger Zone -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm rounded-lg border-2 border-red-200">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-red-600 mb-2">Danger Zone</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Once you delete this device, there is no going back. Please be certain.
                        @if($device->user)
                            <span class="block mt-2 text-red-600 font-semibold">Warning: This device is currently linked to {{ $device->user->name }}. You must unlink it first.</span>
                        @endif
                    </p>
                    <form action="{{ route('devices.destroy', $device) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this device? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" {{ $device->user ? 'disabled' : '' }}>
                            Delete Device
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
