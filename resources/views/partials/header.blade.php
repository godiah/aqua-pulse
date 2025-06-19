<header class="">
    <div
        class="bg-white shadow-md w-full mx-auto px-4 sm:px-8 py-4 flex flex-col sm:flex-row justify-between items-start sm:items-center fixed z-50 top-0">
        <h1 class="text-2xl font-bold">AquaPulse</h1>
        <div class="flex flex-row justify-between items-center mt-2 sm:mt-0 w-full sm:w-auto">
            {{-- <span class="text-sm font-body mr-4">Last Updated: <span id="lastUpdated">May 1, 2025 10:30 AM</span></span> --}}
            <button class="btn-primary p-2 mr-4 rounded-lg font-body hover:bg-primary-hover">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                </svg>
            <button
                class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
                {{-- @click="toggleProfileMenu" --}}
                {{-- @keydown.escape="closeProfileMenu" --}}
                {{-- v-click-outside="closeProfileMenu" --}}
                aria-label="Account"
                aria-haspopup="true"
              >
                <img
                  class="object-cover w-8 h-8 rounded-full"
                  src="{{ asset('images/profile-photo.png') }}"
                  alt=""
                  aria-hidden="true"
                />
              </button>
        </div>
    </div>
</header>
