<div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl shadow-lg text-white overflow-hidden">

    <div class="p-6">

        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-7 h-7"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M15 17h5l-1.4-1.4A2 2 0 0118 14.17V11A6 6 0 006 11v3.17c0 .53-.21 1.04-.59 1.42L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>

                    </svg>

                </div>

                <div>

                    <h3 class="font-bold text-lg">

                        Important Announcement

                    </h3>

                    <p class="text-sm text-blue-100">

                        Pinned Notification

                    </p>

                </div>

            </div>

            @if($important)

                <span class="bg-yellow-400 text-yellow-900 text-xs font-bold px-3 py-1 rounded-full">

                    📌 PINNED

                </span>

            @endif

        </div>

        @if($important)

            <div class="mt-6">

                <h2 class="text-2xl font-bold">

                    {{ $important->title }}

                </h2>

                <p class="mt-4 text-blue-100 leading-7">

                    {{ Str::limit($important->description,180) }}

                </p>

            </div>

            <div class="mt-6 flex flex-wrap gap-2">

                <span class="bg-white/20 px-3 py-1 rounded-full text-sm">

                    {{ $important->category }}

                </span>

                @if($important->department)

                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm">

                        {{ $important->department }}

                    </span>

                @endif

                <span class="bg-white/20 px-3 py-1 rounded-full text-sm">

                    {{ $important->priority }}

                </span>

            </div>

            <div class="mt-6 pt-5 border-t border-white/20">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm text-blue-100">

                            Published By

                        </p>

                        <p class="font-semibold">

                            {{ $important->published_by }}

                        </p>

                    </div>

                    <div class="text-right">

                        <p class="text-sm text-blue-100">

                            Published On

                        </p>

                        <p class="font-semibold">

                            {{ $important->publish_date->format('d M Y') }}

                        </p>

                    </div>

                </div>
            </div>

            <div class="mt-6">

                <a href="{{ route('notifications.show', $important->id) }}"
                   class="w-full inline-flex justify-center items-center gap-2 bg-white text-blue-700 font-semibold px-4 py-3 rounded-xl hover:bg-blue-50 transition">

                    View Announcement

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-5 h-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"/>

                    </svg>

                </a>

            </div>

        @else

            <div class="py-12 text-center">

                <div class="text-5xl mb-4">

                    📢

                </div>

                <h3 class="text-xl font-semibold">

                    No Important Announcement

                </h3>

                <p class="mt-2 text-blue-100">

                    There are no pinned notices available.

                </p>

            </div>

        @endif

    </div>

</div>