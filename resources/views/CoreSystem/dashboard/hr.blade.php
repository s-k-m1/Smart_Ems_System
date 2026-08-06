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
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Total Employees</h3>
                <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
            <p id="hr-total-employees" class="text-2xl sm:text-3xl font-bold text-slate-800">{{ $totalEmployees }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Today's Attendance</h3>
                <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
            <p id="hr-today-attendance" class="text-2xl sm:text-3xl font-bold text-blue-600">{{ $todayAttendance }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Pending Leaves</h3>
                <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p id="hr-pending-leaves" class="text-2xl sm:text-3xl font-bold text-yellow-600">{{ $pendingLeaves }}</p>
        </div>
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-medium text-slate-500">Active Employees</h3>
                <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p id="hr-active-employees" class="text-2xl sm:text-3xl font-bold text-green-600">{{ $activeEmployees }}</p>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">Monthly Attendance Trend</h3>
            <canvas id="hrAttendanceChart" height="200"></canvas>
        </div>

        <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100">
            <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">Department Distribution</h3>
            <canvas id="hrDeptChart" height="200"></canvas>
        </div>
    </div>

    {{-- Working Hours --}}
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 mb-8">
        <h3 class="text-base sm:text-lg font-semibold text-slate-800 mb-4">Total Working Hours per Month</h3>
        <canvas id="hrHoursChart" height="120"></canvas>
    </div>

    {{-- Pending Leave Requests --}}
    <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-sm border border-slate-100 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base sm:text-lg font-semibold text-slate-800">Pending Leave Requests</h3>
            <a href="/leave" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="p-3 text-sm font-medium text-slate-500">Employee</th>
                        <th class="p-3 text-sm font-medium text-slate-500">Type</th>
                        <th class="p-3 text-sm font-medium text-slate-500">Dates</th>
                        <th class="p-3 text-sm font-medium text-slate-500">Days</th>
                        <th class="p-3 text-sm font-medium text-slate-500">Reason</th>
                        <th class="p-3 text-sm font-medium text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingLeaveList as $leave)
                    <tr class="border-t border-slate-100">
                        <td class="p-3 font-medium text-slate-700">{{ $leave->employee?->name ?? 'N/A' }}</td>
                        <td class="p-3 text-slate-600">{{ $leave->type }}</td>
                        <td class="p-3 text-slate-600 whitespace-nowrap">{{ $leave->from_date }} → {{ $leave->to_date }}</td>
                        <td class="p-3 text-slate-600">{{ $leave->days }}</td>
                        <td class="p-3 text-slate-500 max-w-[220px] truncate" title="{{ $leave->reason }}">{{ $leave->reason }}</td>
                        <td class="p-3">
                            <div class="flex gap-2">
                                <form action="/leave/{{ $leave->id }}/approve" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-green-100 text-green-700 hover:bg-green-200 text-sm font-medium transition">Approve</button>
                                </form>
                                <form action="/leave/{{ $leave->id }}/reject" method="POST" onsubmit="return confirm('Reject this leave request?')">
                                    @csrf
                                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-100 text-red-600 hover:bg-red-200 text-sm font-medium transition">Reject</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-slate-400">No pending leave requests</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Navigation Cards --}}
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
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <h3 class="text-base sm:text-lg font-semibold text-slate-800">Notifications</h3>
                        @php $dashUnread = auth()->user()->unreadNotificationsCount(); @endphp
                        @if($dashUnread > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold min-w-5 h-5 px-1.5 rounded-full flex items-center justify-center">{{ $dashUnread > 99 ? '99+' : $dashUnread }}</span>
                        @endif
                    </div>
                    <p class="text-slate-500 text-sm mt-0.5">View company notifications</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var COLORS = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4', '#ec4899', '#f97316'];

    var attCtx = document.getElementById('hrAttendanceChart');
    var hrAttendanceChart = new Chart(attCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                { label: 'Present', data: [], backgroundColor: 'rgba(34, 197, 94, 0.7)', borderColor: 'rgb(34, 197, 94)', borderWidth: 1 },
                { label: 'Late/Undertime', data: [], backgroundColor: 'rgba(245, 158, 11, 0.7)', borderColor: 'rgb(245, 158, 11)', borderWidth: 1 },
                { label: 'Absent', data: [], backgroundColor: 'rgba(239, 68, 68, 0.7)', borderColor: 'rgb(239, 68, 68)', borderWidth: 1 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: { x: { stacked: true, grid: { display: false } }, y: { stacked: true, beginAtZero: true } },
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 14 } } }
        }
    });

    var hoursCtx = document.getElementById('hrHoursChart');
    var hrHoursChart = new Chart(hoursCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Total Hours',
                data: [],
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderColor: '#6366f1',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#6366f1',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: { x: { grid: { display: false } }, y: { beginAtZero: true, ticks: { callback: function(v) { return v + 'h'; } } } },
            plugins: { legend: { display: false } }
        }
    });

    var deptCtx = document.getElementById('hrDeptChart');
    var hrDeptChart = new Chart(deptCtx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{ data: [], backgroundColor: [], borderWidth: 2, borderColor: '#ffffff' }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, boxWidth: 12 } } },
            cutout: '55%'
        }
    });

    function fetchHrData() {
        fetch('/hr/dashboard/chart-data')
            .then(function (r) { return r.json(); })
            .then(function (data) {
                document.getElementById('hr-total-employees').textContent = data.totalEmployees;
                document.getElementById('hr-today-attendance').textContent = data.todayAttendance;
                document.getElementById('hr-pending-leaves').textContent = data.pendingLeaves;
                document.getElementById('hr-active-employees').textContent = data.activeEmployees;

                hrAttendanceChart.data.labels = data.months;
                hrAttendanceChart.data.datasets[0].data = data.presentData;
                hrAttendanceChart.data.datasets[1].data = data.lateData;
                hrAttendanceChart.data.datasets[2].data = data.absentData;
                hrAttendanceChart.update('none');

                hrHoursChart.data.labels = data.months;
                hrHoursChart.data.datasets[0].data = data.workingHoursData;
                hrHoursChart.update('none');

                var deptLabels = Object.keys(data.deptStats);
                var deptValues = Object.values(data.deptStats);
                hrDeptChart.data.labels = deptLabels;
                hrDeptChart.data.datasets[0].data = deptValues;
                hrDeptChart.data.datasets[0].backgroundColor = COLORS.slice(0, deptLabels.length);
                hrDeptChart.update('none');
            })
            .catch(function (err) { console.warn('HR dashboard poll error:', err); });
    }

    fetchHrData();
    setInterval(fetchHrData, 15000);

    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) fetchHrData();
    });
    window.addEventListener('focus', fetchHrData);
    window.addEventListener('storage', function (e) {
        if (e.key === 'attendance_updated') fetchHrData();
    });
});
</script>
@endpush