<div
    class="w-full bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 mb-6 overflow-hidden">

    <!-- Top Border -->
    <div class="
        @if($notification->priority=='High')
            bg-red-500
        @elseif($notification->priority=='Medium')
            bg-amber-500
        @else
            bg-green-500
        @endif
        h-1">
    </div>

    <div class="p-4 sm:p-6">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-5">

            <!-- Left -->
            <div class="flex flex-col sm:flex-row items-start gap-4 flex-1 min-w-0">

                <!-- Icon -->
                <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-7 h-7 text-blue-600"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 11H5m14-7H5m14 14H5"/>

                    </svg>

                </div>

                <!-- Title -->
                <div class="flex-1 min-w-0">

                    <h2 class="text-lg sm:text-xl font-semibold text-slate-800 break-words">

                        {{ $notification->title }}

                    </h2>

                    <!-- Category -->
                    <div class="flex flex-wrap gap-2 mt-3">

                        <span
                            class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">

                            {{ $notification->category }}

                        </span>

                        @if($notification->department)

                        <span
                            class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs">

                            {{ $notification->department }}

                        </span>

                        @endif

                    </div>

                </div>

            </div>

            <!-- Right Badges -->
            <div class="flex flex-wrap gap-2 lg:justify-end">

                @if($notification->is_pinned)

                <span
                    class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-full font-semibold">

                    📌 Pinned

                </span>

                @endif

                @if($notification->priority=="High")

                <span
                    class="bg-red-100 text-red-700 text-xs px-3 py-1 rounded-full font-semibold">

                    High

                </span>

                @elseif($notification->priority=="Medium")

                <span
                    class="bg-amber-100 text-amber-700 text-xs px-3 py-1 rounded-full font-semibold">

                    Medium

                </span>

                @else

                <span
                    class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full font-semibold">

                    Low

                </span>

                @endif

            </div>

        </div>

        <!-- Description -->
        <div class="mt-5">

            <p class="text-gray-600 leading-7 break-words text-sm sm:text-base">

                {{ Str::limit($notification->description,220) }}

            </p>

        </div>

        <!-- Attachment -->
        @if($notification->attachment)

        <div class="mt-5">

            <a href="{{ asset('storage/'.$notification->attachment) }}"
               target="_blank"
               class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 font-medium">

                📎 View Attachment

            </a>

        </div>

        @endif

        <!-- Footer -->
        <div
            class="mt-6 pt-5 border-t border-slate-200 flex flex-col lg:flex-row lg:justify-between lg:items-center gap-5">

            <!-- Author & Date -->
            <div class="flex flex-col sm:flex-row flex-wrap gap-3 sm:gap-6 text-sm text-slate-500">

                <div class="flex items-center gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5.121 17.804A8.962 8.962 0 0112 15a8.962 8.962 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

                    </svg>

                    <span class="break-words">

                        {{ $notification->published_by }}

                    </span>

                </div>

                <div class="flex items-center gap-2">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 shrink-0"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10m2 10H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2z"/>

                    </svg>

                    <span>

                        {{ $notification->publish_date->format('d M Y • h:i A') }}

                    </span>

                </div>

            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                <a href="{{ route('notifications.show',$notification->id) }}"
                    class="w-full sm:w-auto text-center px-4 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 text-sm font-medium transition">

                    View

                </a>

                <form
                    action="{{ route('notifications.destroy',$notification->id) }}"
                    method="POST"
                    class="w-full sm:w-auto"
                    onsubmit="return confirm('Delete this notification?')">

                    @csrf
                    @method('DELETE')

                    <button
                        class="w-full sm:w-auto px-4 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition">

                        Delete

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>