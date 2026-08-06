@extends('CoreSystem.layouts.app')

@section('title', $notification->title)

@section('content')

<div class="min-h-[calc(100vh-8rem)] flex items-center justify-center px-4 sm:px-6 py-8">

    <div class="w-full max-w-2xl">

        <div class="bg-white rounded-2xl shadow-lg border border-slate-200 overflow-hidden">

            <!-- Top accent -->
            <div class="
                @if($notification->priority=='High')
                    bg-red-500
                @elseif($notification->priority=='Medium')
                    bg-amber-500
                @else
                    bg-green-500
                @endif
                h-1.5">
            </div>

            <!-- Header -->
            <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-start justify-between gap-4">

                <div class="min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">

                        <h1 class="text-xl sm:text-2xl font-bold text-slate-800 break-words">
                            {{ $notification->title }}
                        </h1>

                        @if($notification->is_pinned)
                            <span class="bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-semibold">📌 Pinned</span>
                        @endif
                    </div>

                    <div class="flex flex-wrap gap-2 mt-3 text-xs">
                        <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">{{ $notification->category }}</span>

                        @if($notification->department)
                            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600">{{ $notification->department }}</span>
                        @endif

                        @if($notification->priority == 'High')
                            <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 font-semibold">High Priority</span>
                        @elseif($notification->priority == 'Medium')
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 font-semibold">Medium</span>
                        @else
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">Low</span>
                        @endif
                    </div>
                </div>

                <a href="{{ route('notifications.index') }}"
                   class="shrink-0 w-9 h-9 rounded-lg bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-slate-500 transition"
                   title="Back to notifications">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </a>

            </div>

            <!-- Body -->
            <div class="px-6 sm:px-8 py-6 space-y-6">

                <!-- Meta grid -->
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-400 text-xs uppercase tracking-wide">Published By</p>
                        <p class="text-slate-800 font-medium mt-1 break-words">{{ $notification->published_by }}</p>
                    </div>
                    <div>
                        <p class="text-slate-400 text-xs uppercase tracking-wide">Publish Date</p>
                        <p class="text-slate-800 font-medium mt-1">{{ $notification->publish_date->format('d M Y • h:i A') }}</p>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <p class="text-slate-400 text-xs uppercase tracking-wide">Description</p>
                    <div class="mt-2 p-4 bg-slate-50 rounded-xl text-slate-700 leading-7 break-words text-sm sm:text-base">
                        {{ $notification->description }}
                    </div>
                </div>

                @if($notification->attachment)
                    <a href="{{ asset('storage/'.$notification->attachment) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 font-medium text-sm transition">
                        📎 View Attachment
                    </a>
                @endif

            </div>

            <!-- Footer -->
            <div class="px-6 sm:px-8 py-4 border-t border-slate-200 bg-slate-50 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <span class="text-xs text-slate-500">
                    Viewed {{ now()->format('d M Y • h:i A') }}
                </span>

                <a href="{{ route('notifications.index') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-2 rounded-lg bg-slate-800 hover:bg-slate-900 text-white text-sm font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to notifications
                </a>

            </div>

        </div>

    </div>

</div>

@endsection