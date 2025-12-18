<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Log Details #{{ $log->id }}
            </h2>
            <a href="{{ route('logs.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                Back to Logs
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Level</label>
                            <span class="mt-1 px-3 py-1 text-sm font-semibold rounded-full inline-block
                                {{ $log->level === 'info' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $log->level === 'warning' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $log->level === 'error' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $log->level === 'critical' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ ucfirst($log->level) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Logged At</label>
                            <p class="mt-1 text-gray-900">{{ $log->logged_at->format('M d, Y H:i:s') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Device</label>
                            <p class="mt-1">
                                <a href="{{ route('devices.show', $log->device) }}" class="text-blue-600 hover:text-blue-900">
                                    Device #{{ $log->device_id }}
                                </a>
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Source</label>
                            <p class="mt-1 text-gray-900">{{ $log->source }}</p>
                        </div>
                        @if($log->type)
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Type</label>
                            <p class="mt-1 text-gray-900">{{ $log->type }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Message</label>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-gray-900">{{ $log->message }}</p>
                        </div>
                    </div>

                    @if($log->details)
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Additional Details</label>
                        <div class="bg-gray-900 p-4 rounded-md">
                            <pre class="text-green-400 text-sm overflow-x-auto">{{ json_encode($log->details, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                    @endif

                    <div class="flex justify-end gap-2">
                        <form action="{{ route('logs.destroy', $log) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700" onclick="return confirm('Delete this log?')">
                                Delete Log
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
