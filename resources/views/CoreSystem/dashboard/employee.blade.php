<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Smart EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
    @include('CoreSystem.layouts.sidebar')

    <div class="ml-64 min-h-screen">
        <header class="bg-white border-b border-slate-200 px-8 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">My Dashboard</h1>
                    <p class="text-sm text-slate-500 mt-0.5">Welcome back, {{ Auth::user()->name }}</p>
                </div>
                <span class="text-xs text-slate-400">{{ now()->format('l, F j, Y') }}</span>
            </div>
        </header>

        <div class="p-8">
            @php
                $employee = Auth::user()->employee;
            @endphp

            @if($employee)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-slate-500">Present Days</h3>
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-green-600">{{ $employee->present_days }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-slate-500">Leave Taken</h3>
                        <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-yellow-600">{{ $employee->leave_taken }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-slate-500">Department</h3>
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-blue-600">{{ $employee->department }}</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-sm font-medium text-slate-500">Position</h3>
                        <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-800">{{ $employee->position }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <a href="/attendance" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-blue-200 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">My Attendance</h3>
                            <p class="text-slate-500 text-sm mt-0.5">View your attendance records</p>
                        </div>
                    </div>
                </a>
                <a href="/leave" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-yellow-200 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center group-hover:bg-yellow-100 transition">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">My Leave Records</h3>
                            <p class="text-slate-500 text-sm mt-0.5">View your leave history and apply for leave</p>
                        </div>
                    </div>
                </a>
                <a href="/notifications" class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-purple-200 transition group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Notifications</h3>
                            <p class="text-slate-500 text-sm mt-0.5">View your notifications</p>
                        </div>
                    </div>
                </a>
            </div>
            @else
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-slate-100 text-center">
                <p class="text-slate-500">Employee profile not found. Please contact the administrator.</p>
            </div>
            @endif
        </div>
    </div>
</body>
</html>
