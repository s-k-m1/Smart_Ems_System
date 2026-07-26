@extends('CoreSystem.layouts.app')

@section('title', 'HR Dashboard - Smart EMS')

@section('content')
<header class="bg-white border-b border-slate-200 px-4 sm:px-8 py-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">HR Dashboard</h1>
            <p class="text-sm text-slate-500 mt-0.5">Manage employee information, attendance, and leave</p>
        </div>
        <span class="text-xs text-slate-400">{{ now()->format('l, F j, Y') }}</span>
    </div>
</header>

<div class="p-4 sm:p-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Total Employees</h3>
                <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-slate-800">{{ \App\Models\Employee::count() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Today's Attendance</h3>
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ \App\Models\Attendance::whereDate('date', now()->toDateString())->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Pending Leaves</h3>
                <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ \App\Models\Leave::where('status', 'Pending')->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Notifications</h3>
                <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-purple-600">{{ \App\Models\Notification::count() }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
        <a href="/employees" class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-indigo-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition shrink-0">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-800">View Employees</h3>
                    <p class="text-slate-500 text-sm mt-0.5">View and manage employee profiles</p>
                </div>
            </div>
        </a>
        <a href="/attendance" class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-blue-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-800">Attendance Management</h3>
                    <p class="text-slate-500 text-sm mt-0.5">Manage attendance records</p>
                </div>
            </div>
        </a>
        <a href="/leave" class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-yellow-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center group-hover:bg-yellow-100 transition shrink-0">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-800">Leave Management</h3>
                    <p class="text-slate-500 text-sm mt-0.5">Review and process leave requests</p>
                </div>
            </div>
        </a>
        <a href="/notifications" class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-purple-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-800">Notifications</h3>
                    <p class="text-slate-500 text-sm mt-0.5">View company notifications</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
