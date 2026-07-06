<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-6 py-5">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <!-- Left Section -->
            <div class="flex items-center gap-5">

                <!-- EMS Logo -->
                <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055a12.083 12.083 0 01-6.16-9.477L12 14z"/>

                    </svg>
                </div>

                <!-- Title -->
                <div>

                    <h1 class="text-3xl font-bold text-slate-800">

                        Notices & Notifications

                    </h1>

                    <p class="text-gray-500 mt-1">

                        Stay informed about important company announcements and updates.

                    </p>

                </div>

            </div>

            <!-- Right Section -->
            <div class="flex items-center gap-4">

                <!-- Search -->
                <form action="{{ route('notifications.index') }}" method="GET">

                    <div class="relative">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-4 top-3.5 h-5 w-5 text-gray-400"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>

                        </svg>

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search notices..."
                            class="w-72 pl-11 pr-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    </div>

                </form>

                <!-- Notification Bell -->
                <button
                    class="relative w-12 h-12 rounded-xl border border-gray-200 flex items-center justify-center hover:bg-blue-50 transition">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 text-gray-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 17h5l-1.4-1.4A2 2 0 0118 14.17V11a6 6 0 10-12 0v3.17c0 .53-.21 1.04-.59 1.42L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>

                    </svg>

                    <span
                        class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">

                        {{ $recent->count() }}

                    </span>

                </button>

                <!-- User -->
                <div
                    class="flex items-center gap-3 bg-gray-50 rounded-xl px-3 py-2 border">

                    <div
                        class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">

                        {{ strtoupper(substr(Auth::user()->name ?? 'A',0,1)) }}

                    </div>

                    <div class="hidden md:block">

                        <h3 class="font-semibold text-gray-800">

                            {{ Auth::user()->name ?? 'Administrator' }}

                        </h3>

                        <p class="text-sm text-gray-500">

                            Employee Management System

                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>
</header>