@extends('CoreSystem.layouts.app')

@section('title', 'Notifications')

@push('styles')
<style>
    body{
        font-family:'Inter',sans-serif;
    }
    .scrollbar-hide::-webkit-scrollbar{
        display:none;
    }
    .scrollbar-hide{
        -ms-overflow-style:none;
        scrollbar-width:none;
    }
</style>
@endpush

@section('content')

    @include('NotificationManagement.notifications.header')

    <div class="px-4 sm:px-6 py-4 sm:py-6">

        {{-- Tabs --}}
        @include('NotificationManagement.notifications.tabs')

        {{-- Unread summary + actions --}}
        <div class="mt-6 mb-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div id="unreadSummary" class="flex items-center gap-2 text-sm text-slate-600">
                @if($unreadCount > 0)
                    <span id="unreadDot" class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                    <span id="unreadText"><strong class="text-slate-800">{{ $unreadCount }}</strong> unread notification{{ $unreadCount > 1 ? 's' : '' }}</span>
                @else
                    <span id="unreadDot" class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                    <span id="unreadText">You're all caught up</span>
                @endif
            </div>

            <div class="flex flex-wrap items-center gap-2">

            <form id="markAllForm" method="POST" action="{{ route('notifications.mark-all-read') }}" class="{{ $unreadCount > 0 ? '' : 'hidden' }}">
                @csrf
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 text-sm font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 13l4 4L19 7"/>
                    </svg>
                    Mark all as read
                </button>
            </form>

            @if(auth()->user()->hasPermission('manage_notifications'))
                <a href="{{ route('notifications.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 text-sm font-medium transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Notification
                </a>
            @endif

            </div>
        </div>

        <div class="max-w-3xl mx-auto">

            @forelse($notifications as $notification)

                @include('NotificationManagement.notifications.notification-card')

            @empty

                <div class="bg-white rounded-2xl shadow-sm p-12 text-center">

                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486740.png"
                         class="w-28 mx-auto">

                    <h2 class="mt-5 text-xl font-semibold text-gray-700">
                        No Notifications Found
                    </h2>

                    <p class="text-gray-500 mt-2">
                        There are currently no notifications available.
                    </p>

                </div>

            @endforelse

            {{-- Pagination --}}
            <div class="mt-8">

                {{ $notifications->appends(request()->query())->links() }}

            </div>

        </div>

    </div>

    @push('scripts')
    <script>
        async function refreshUnreadCounts() {
            try {
                const res = await fetch("{{ route('notifications.unread-counts') }}", {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                if (!res.ok) return;
                const data = await res.json();

                const total = data['All'] ?? 0;

                document.querySelectorAll('[data-unread-badge]').forEach(function (el) {
                    const key = el.dataset.unreadBadge;
                    const n = data[key] ?? 0;
                    const badge = el.querySelector('.unread-count');
                    const dot = el.querySelector('.relative.flex.w-2.h-2');

                    if (badge) {
                        if (n > 0) {
                            badge.textContent = n;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }

                    if (dot) dot.remove();

                    if (n > 0) {
                        const newDot = document.createElement('span');
                        newDot.className = 'relative flex w-2 h-2';
                        newDot.innerHTML = '<span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex rounded-full w-2 h-2 bg-red-500"></span>';
                        el.appendChild(newDot);
                    }
                });

                const bell = document.getElementById('bellUnread');
                if (bell) {
                    if (total > 0) {
                        bell.textContent = total > 99 ? '99+' : total;
                        bell.classList.remove('hidden');
                    } else {
                        bell.classList.add('hidden');
                    }
                }

                const summaryDot = document.getElementById('unreadDot');
                const summaryText = document.getElementById('unreadText');
                const markAll = document.getElementById('markAllForm');

                if (summaryDot && summaryText) {
                    summaryDot.className = 'w-2.5 h-2.5 rounded-full ' + (total > 0 ? 'bg-red-500' : 'bg-green-500');
                    summaryText.innerHTML = total > 0
                        ? '<strong class="text-slate-800">' + total + '</strong> unread notification' + (total > 1 ? 's' : '')
                        : "You're all caught up";
                }

                if (markAll) {
                    markAll.classList.toggle('hidden', total === 0);
                }
            } catch (e) {}
        }

        document.addEventListener('DOMContentLoaded', refreshUnreadCounts);
        setInterval(refreshUnreadCounts, 20000);
    </script>
    @endpush

@endsection
