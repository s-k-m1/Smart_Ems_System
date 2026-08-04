@extends('CoreSystem.layouts.app')

@section('title', 'Employee Dashboard - Smart EMS')

@section('content')
<header class="bg-white border-b border-slate-200 px-4 sm:px-8 py-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">My Dashboard</h1>
            <p class="text-sm text-slate-500 mt-0.5">Welcome back, {{ Auth::user()->name }}</p>
        </div>
        <span class="text-xs text-slate-400">{{ now()->format('l, F j, Y') }}</span>
    </div>
</header>

<div class="p-4 sm:p-8">
    @if($employee)
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Present Days <span class="text-slate-300">({{ now()->format('F') }})</span></h3>
                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-green-600">{{ $presentDays }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Leave Taken <span class="text-slate-300">(approved)</span></h3>
                <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $leaveTaken }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Attendance Rate <span class="text-slate-300">({{ now()->year }})</span></h3>
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $attendanceRate }}%</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Working Hours <span class="text-slate-300">(this month)</span></h3>
                <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl sm:text-3xl font-bold text-indigo-600">{{ number_format($workingHours, 1) }}h</p>
        </div>
    </div>

    {{-- My Attendance Chart --}}
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 mb-6 sm:mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base sm:text-lg font-semibold text-slate-800">My Monthly Attendance (last 6 months)</h3>
            <a href="/attendance" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">View details</a>
        </div>
        <canvas id="myAttendanceChart" height="150"></canvas>
    </div>

    {{-- Recent Attendance + Pending Leaves --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base sm:text-lg font-semibold text-slate-800">Recent Attendance</h3>
                <a href="/attendance" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">View all</a>
            </div>
            @if($recentAttendance->isNotEmpty())
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-3 text-sm font-medium text-slate-500">Date</th>
                            <th class="p-3 text-sm font-medium text-slate-500">Status</th>
                            <th class="p-3 text-sm font-medium text-slate-500">Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAttendance as $att)
                        <tr class="border-t border-slate-100">
                            <td class="p-3 text-slate-600 whitespace-nowrap">{{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}</td>
                            <td class="p-3">
                                @if($att->status === 'Present')
                                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Present</span>
                                @elseif($att->status === 'Late')
                                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Late</span>
                                @elseif($att->status === 'Undertime')
                                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-semibold">Undertime</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Absent</span>
                                @endif
                            </td>
                            <td class="p-3 text-slate-600">{{ $att->working_hours ? number_format($att->working_hours, 1) . 'h' : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-slate-400 text-sm text-center py-6">No attendance records yet.</p>
            @endif
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base sm:text-lg font-semibold text-slate-800">My Leave Status</h3>
                <a href="/leave" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">View all</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-sm text-slate-500">Approved</p>
                    <p class="text-2xl font-bold text-green-600 mt-1">{{ $leaveTaken }} days</p>
                </div>
                <div class="bg-yellow-50 rounded-xl p-4">
                    <p class="text-sm text-yellow-600">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600 mt-1">{{ $pendingLeaves }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-4">
                    <p class="text-sm text-slate-500">Department</p>
                    <p class="text-lg font-bold text-slate-800 mt-1 break-words">{{ $employee->department }}</p>
                </div>
            </div>
            <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-100">
                <p class="text-sm text-slate-500">Position</p>
                <p class="text-lg font-bold text-slate-800 mt-1 break-words">{{ $employee->position }}</p>
            </div>
        </div>
    </div>

    {{-- Navigation Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <a href="/attendance" class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-blue-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-800">My Attendance</h3>
                    <p class="text-slate-500 text-sm mt-0.5">View your attendance records</p>
                </div>
            </div>
        </a>
        <a href="/leave" class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 hover:shadow-md hover:border-yellow-200 transition group">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center group-hover:bg-yellow-100 transition shrink-0">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base sm:text-lg font-semibold text-slate-800">My Leave Records</h3>
                    <p class="text-slate-500 text-sm mt-0.5">View your leave history and apply for leave</p>
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
                    <p class="text-slate-500 text-sm mt-0.5">View your notifications</p>
                </div>
            </div>
        </a>
    </div>
    @else
    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-100 text-center">
        <p class="text-slate-500">Employee profile not found. Please contact the administrator.</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
@if($employee)
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('myAttendanceChart');
    if (!ctx) return;

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($months),
            datasets: [
                {
                    label: 'Present',
                    data: @json($presentData),
                    backgroundColor: 'rgba(34, 197, 94, 0.7)',
                    borderColor: 'rgb(34, 197, 94)',
                    borderWidth: 1
                },
                {
                    label: 'Absent',
                    data: @json($absentData),
                    backgroundColor: 'rgba(239, 68, 68, 0.7)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1
                },
                {
                    label: 'Late',
                    data: @json($lateData),
                    backgroundColor: 'rgba(245, 158, 11, 0.7)',
                    borderColor: 'rgb(245, 158, 11)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: { x: { stacked: true, grid: { display: false } }, y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } } },
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 14 } } }
        }
    });

    // Live update when attendance changes in another tab
    window.addEventListener('storage', function (e) {
        if (e.key === 'attendance_updated') window.location.reload();
    });
});
</script>
@endif
@endpush