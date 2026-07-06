<div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

    <!-- Header -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">

        <div>

            <h3 class="text-lg font-semibold text-slate-800">
                Recent Notifications
            </h3>

            <p class="text-sm text-slate-500">
                Latest company updates
            </p>

        </div>

        <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
            {{ $recent->count() }}
        </span>

    </div>

    <!-- Notification List -->
    <div class="divide-y divide-slate-100">

        @forelse($recent as $item)

            <a href="{{ route('notifications.show',$item->id) }}"
               class="block p-5 hover:bg-slate-50 transition">

                <div class="flex items-start gap-4">

                    <!-- Category Icon -->
                    <div class="flex-shrink-0">

                        @php
                            $color = match($item->priority){
                                'High' => 'bg-red-100 text-red-600',
                                'Medium' => 'bg-amber-100 text-amber-600',
                                default => 'bg-green-100 text-green-600'
                            };
                        @endphp

                        <div class="w-11 h-11 rounded-xl {{ $color }} flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M15 17h5l-1.4-1.4A2 2 0 0118 14.17V11A6 6 0 006 11v3.17c0 .53-.21 1.04-.59 1.42L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>

                            </svg>

                        </div>

                    </div>

                    <!-- Content -->
                    <div class="flex-1">

                        <div class="flex items-center justify-between">

                            <h4 class="font-semibold text-slate-800 line-clamp-1">
                                {{ $item->title }}
                            </h4>

                            @if($item->is_pinned)
                                <span class="text-yellow-500 text-sm">
                                    📌
                                </span>
                            @endif

                        </div>

                        <p class="text-sm text-slate-500 mt-1 line-clamp-2">
                            {{ Str::limit($item->description,70) }}
                        </p>

                        <div class="flex items-center justify-between mt-3">

                            <span class="text-xs px-2 py-1 rounded-full bg-slate-100 text-slate-600">
                                {{ $item->category }}
                            </span>

                            <span class="text-xs text-slate-400">
                                {{ $item->publish_date->diffForHumans() }}
                            </span>

                        </div>

                    </div>

                </div>

            </a>

        @empty

            <div class="p-10 text-center">

                <div class="text-5xl mb-3">
                    🔔
                </div>

                <h4 class="font-semibold text-slate-700">
                    No Recent Notifications
                </h4>

                <p class="text-sm text-slate-500 mt-2">
                    New notifications will appear here.
                </p>

            </div>

        @endforelse

    </div>

    <!-- Footer -->
    @if($recent->count())

        <div class="px-6 py-4 border-t border-slate-100">

            <a href="{{ route('notifications.index') }}"
               class="block text-center text-blue-600 font-semibold hover:text-blue-800">

                View All Notifications →

            </a>

        </div>

    @endif

</div>