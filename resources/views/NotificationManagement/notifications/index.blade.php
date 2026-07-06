<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System - Notifications</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Inter',sans-serif;
            background:#f8fafc;
        }

        .scrollbar-hide::-webkit-scrollbar{
            display:none;
        }

        .scrollbar-hide{
            -ms-overflow-style:none;
            scrollbar-width:none;
        }
    </style>
</head>

<body class="bg-slate-100">

<div class="min-h-screen">

    {{-- Header --}}
    @include('NotificationManagement.notifications.header')

    <div class="max-w-7xl mx-auto px-6 py-6">

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

</div>
</body>
</html>