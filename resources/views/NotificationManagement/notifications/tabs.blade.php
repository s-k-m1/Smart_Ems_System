@php
$categories = [
    'All' => 'All Notices',
    'Company' => 'Company',
    'HR' => 'HR',
    'Policies' => 'Policies',
    'Training' => 'Training',
    'Events' => 'Events',
];

$currentCategory = request('category', 'All');
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-2">

    <div class="flex items-center gap-3 overflow-x-auto whitespace-nowrap">

        @foreach($categories as $key => $label)

            @php
                $unread = $tabUnreadCounts[$key] ?? 0;
                $active = $currentCategory == $key;
            @endphp

            <a href="{{ route('notifications.index',['category'=>$key]) }}"
                data-unread-badge="{{ $key }}"

                class="group flex items-center gap-2 px-5 py-3 rounded-xl transition-all duration-200

                {{ $active
                    ? 'bg-blue-600 text-white shadow-md'
                    : 'bg-slate-50 hover:bg-blue-50 text-slate-700'
                }}">

                {{-- Category Icon --}}
                @switch($key)

                    @case('Company')

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 21h18M5 21V7l8-4 8 4v14"/>

                        </svg>

                    @break

                    @case('HR')

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5V4H2v16h5m10 0v-6H7v6m10 0H7"/>

                        </svg>

                    @break

                    @case('Policies')

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6M7 4h10l2 2v14H5V6l2-2z"/>

                        </svg>

                    @break

                    @case('Training')

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422A12.083 12.083 0 0112 20.055a12.083 12.083 0 01-6.16-9.477L12 14z"/>

                        </svg>

                    @break

                    @case('Events')

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10m2 10H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2z"/>

                        </svg>

                    @break

                    @default

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">

                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 17v-2a4 4 0 014-4h6"/>

                        </svg>

                @endswitch

                <span class="font-medium">

                    {{ $label }}

                </span>

                {{-- Unread (new) badge --}}
                <span class="unread-count text-xs font-bold min-w-6 h-6 px-1.5 rounded-full inline-flex items-center justify-center bg-red-500 text-white transition {{ $unread > 0 ? '' : 'hidden' }}">

                    {{ $unread }}

                </span>

                @if($unread > 0)
                    <span class="relative flex w-2 h-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full w-2 h-2 bg-red-500"></span>
                    </span>
                @endif

            </a>

        @endforeach

    </div>

</div>