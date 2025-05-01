<div id="scheduleModal" class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6 relative">
        <!-- Modal Header -->
        <div class="p-5 border-b border-default">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-heading font-semibold text-primary">Create Pump Schedule</h3>
                <button onclick="closeScheduleModal()" class="text-gray-500 hover:text-accent transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Schedule Form -->
        <div class="mb-6 p-4 bg-light rounded-lg">

            <!-- Days Selection -->
            <div class="mb-4">
                <label class="block text-sm font-body mb-2">Select Days:</label>
                <div class="flex flex-wrap gap-2">
                    <div class="schedule-day px-3 py-1 bg-gray-200 rounded cursor-pointer text-sm font-body"
                        data-day="mon">Mon</div>
                    <div class="schedule-day selected px-3 py-1 bg-secondary text-white rounded cursor-pointer text-sm font-body"
                        data-day="tue">Tue</div>
                    <div class="schedule-day selected px-3 py-1 bg-secondary text-white rounded cursor-pointer text-sm font-body"
                        data-day="wed">Wed</div>
                    <div class="schedule-day px-3 py-1 bg-gray-200 rounded cursor-pointer text-sm font-body"
                        data-day="thu">Thu</div>
                    <div class="schedule-day selected px-3 py-1 bg-secondary text-white rounded cursor-pointer text-sm font-body"
                        data-day="fri">Fri</div>
                    <div class="schedule-day px-3 py-1 bg-gray-200 rounded cursor-pointer text-sm font-body"
                        data-day="sat">Sat</div>
                    <div class="schedule-day px-3 py-1 bg-gray-200 rounded cursor-pointer text-sm font-body"
                        data-day="sun">Sun</div>
                </div>
            </div>

            <!-- Time Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-body mb-2">Start Time:</label>
                    <input type="time" class="time-picker w-full border border-default px-2 py-1 rounded"
                        value="06:30">
                </div>
                <div>
                    <label class="block text-sm font-body mb-2">End Time:</label>
                    <input type="time" class="time-picker w-full border border-default px-2 py-1 rounded"
                        value="07:30">
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="p-5 border-t border-default bg-light rounded-b-xl">
                <div class="flex justify-end space-x-4">
                    <button onclick="closeScheduleModal()"
                        class="btn-secondary px-6 py-3 rounded-lg font-body font-medium">
                        Cancel
                    </button>
                    <button class="btn-primary px-8 py-3 rounded-lg font-body font-medium flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Save Schedule
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openScheduleModal() {
        document.getElementById('scheduleModal').classList.remove('hidden');
    }

    function closeScheduleModal() {
        document.getElementById('scheduleModal').classList.add('hidden');
    }
</script>
