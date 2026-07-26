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

    <div class="px-4 sm:px-6 py-4 sm:py-6">

        {{-- Tabs --}}
        @include('NotificationManagement.notifications.tabs')

        <div class="grid grid-cols-12 gap-6 mt-6">

            {{-- LEFT CONTENT --}}
            <div class="col-span-12 xl:col-span-8">

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

                    {{ $notifications->links() }}

                </div>

            </div>

        </div>

    </div>

@endsection