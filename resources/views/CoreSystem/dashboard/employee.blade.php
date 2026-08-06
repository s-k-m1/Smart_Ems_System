@extends('CoreSystem.layouts.app')

@section('title', 'Employee Dashboard - Smart EMS')

@section('content')
<header class="bg-white border-b border-slate-200 px-4 sm:px-6 lg:px-8 py-3 sticky top-0 z-10">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h1 class="text-base sm:text-lg font-bold text-slate-800">My Dashboard</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Welcome back, {{ Auth::user()->name }}</p>
        </div>
        <span class="text-[10px] sm:text-xs text-slate-400 whitespace-nowrap">{{ now()->format('l, F j, Y') }}</span>
    </div>
</header>

<div class="p-4 sm:p-6 lg:p-8 lg:pl-10 lg:pr-10">
    @if($employee)
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
        <div class="bg-white rounded-lg p-4 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-medium text-slate-500">Present Days <span class="text-slate-400">({{ now()->format('F') }})</span></h3>
                <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
             </div>
         </div>
     </div>
        <div class="bg-white rounded-lg p-4 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-medium text-slate-500">Leave Taken <span class="text-slate-400">(approved)</span></h3>
                <div class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-xl font-bold text-yellow-600">{{ $leaveTaken }}</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-medium text-slate-500">Attendance Rate <span class="text-slate-400">({{ now()->year }})</span></h3>
                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
            <p class="text-xl font-bold text-blue-600">{{ $attendanceRate }}%</p>
        </div>
        <div class="bg-white rounded-lg p-4 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-xs font-medium text-slate-500">Working Hours <span class="text-slate-400">(this month)</span></h3>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-xl font-bold text-indigo-600">{{ number_format($workingHours, 1) }}h</p>
        </div>
    </div>

    {{-- Today's Attendance Quick Actions --}}
    <div class="mb-6">
        <div class="bg-gradient-to-r from-slate-50 to-white rounded-xl shadow-sm border border-slate-100 p-4 sm:p-5">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Today's Attendance</h3>
                <a href="/attendance" class="text-[10px] text-blue-500 hover:text-blue-700 font-medium transition">View all →</a>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @if($todayAttendance)
                <div class="flex items-center gap-2 px-3 py-2 bg-green-50 rounded-xl border border-green-100">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-xs font-medium text-green-700">In at {{ $todayAttendance->check_in ?? '--:--' }}</span>
                </div>
@if($todayAttendance->check_out)
                <div class="flex items-center gap-2 px-3 py-2 bg-red-50 rounded-xl border border-red-100">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    <span class="text-xs font-medium text-red-700">Out at {{ $todayAttendance->check_out }}</span>
                </div>
                <form method="POST" action="/attendance/request-edit/{{ $todayAttendance->id }}" class="inline-block">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-amber-500 text-white text-xs font-semibold shadow-sm hover:bg-amber-600 hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Request Edit
                    </button>
                </form>
                @else
                <form method="POST" action="/attendance/quick-check-out" class="inline-block" id="quickCheckOutForm">
                    @csrf
                    <button type="button" onclick="openCheckOutConfirm()" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-red-500 text-white text-xs font-semibold shadow-sm hover:bg-red-600 hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Check Out
                    </button>
                </form>
                @endif
                @else
                @if(now('Asia/Kathmandu')->hour >= 9)
                <form method="POST" action="/attendance/quick-check-in" class="inline-block">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-green-500 text-white text-xs font-semibold shadow-sm hover:bg-green-600 hover:shadow-md transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Check In
                    </button>
                </form>
                @else
                <div class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Starts at 9:00 AM
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>

    {{-- My Attendance Chart --}}
    <div class="bg-white rounded-lg p-4 sm:p-6 shadow-sm border border-slate-100 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-sm font-semibold text-slate-800">My Monthly Attendance (last 6 months)</h3>
            <a href="/attendance" class="text-xs sm:text-sm text-blue-600 hover:text-blue-800 font-medium transition">View details</a>
        </div>
        <div class="relative" style="height: 180px;">
            <canvas id="myAttendanceChart"></canvas>
        </div>
    </div>

    {{-- Recent Attendance + Leave Status --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-lg p-4 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-800">Recent Attendance</h3>
                <a href="/attendance" class="text-xs sm:text-sm text-blue-600 hover:text-blue-800 font-medium transition">View all</a>
            </div>
            @if($recentAttendance->isNotEmpty())
            <div class="overflow-x-auto -mx-4 sm:-mx-6 px-4 sm:px-6">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-2.5 text-[10px] sm:text-xs font-medium text-slate-500">Date</th>
                            <th class="p-2.5 text-[10px] sm:text-xs font-medium text-slate-500">Status</th>
                            <th class="p-2.5 text-[10px] sm:text-xs font-medium text-slate-500">Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentAttendance as $att)
                        <tr class="border-t border-slate-100 hover:bg-slate-50 transition-colors">
                            <td class="p-2.5 text-slate-600 whitespace-nowrap text-xs sm:text-sm">{{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}</td>
                            <td class="p-2.5 text-xs sm:text-sm">
                                @if($att->status === 'Present')
                                    <span class="inline-block px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] sm:text-xs font-semibold">Present</span>
                                @elseif($att->status === 'Late')
                                    <span class="inline-block px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 text-[10px] sm:text-xs font-semibold">Late</span>
                                @elseif($att->status === 'Undertime')
                                    <span class="inline-block px-2 py-0.5 rounded-full bg-orange-100 text-orange-700 text-[10px] sm:text-xs font-semibold">Undertime</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-[10px] sm:text-xs font-semibold">Absent</span>
                                @endif
                            </td>
                            <td class="p-2.5 text-slate-600 text-xs sm:text-sm">{{ $att->working_hours ? number_format($att->working_hours, 1) . 'h' : '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-slate-400 text-sm text-center py-4">No attendance records yet.</p>
            @endif
        </div>

        <div class="bg-white rounded-lg p-4 sm:p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-semibold text-slate-800">My Leave Status</h3>
                <a href="/leave" class="text-xs sm:text-sm text-blue-600 hover:text-blue-800 font-medium transition">View all</a>
            </div>
            <div class="grid grid-cols-3 gap-2 mb-4">
                <div class="bg-slate-50 rounded-lg p-3 text-center">
                    <p class="text-[10px] text-slate-500">Approved</p>
                    <p class="text-lg font-bold text-green-600 mt-1">{{ $leaveTaken }} days</p>
                </div>
                <div class="bg-yellow-50 rounded-lg p-3 text-center">
                    <p class="text-[10px] text-yellow-600">Pending</p>
                    <p class="text-lg font-bold text-yellow-600 mt-1">{{ $pendingLeaves }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-3 text-center">
                    <p class="text-[10px] text-slate-500">Department</p>
                    <p class="text-xs font-bold text-slate-800 mt-1 break-words">{{ $employee->department }}</p>
                </div>
            </div>
            <div class="mt-4 bg-blue-50 rounded-lg p-3 border border-blue-100">
                <p class="text-[10px] text-slate-500">Position</p>
                <p class="text-xs font-bold text-slate-800 mt-1 break-words">{{ $employee->position }}</p>
            </div>
        </div>
    </div>

    {{-- Navigation Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-6">
        <a href="/leave" class="bg-white rounded-lg p-4 shadow-sm border border-slate-100 hover:shadow-md hover:border-yellow-200 transition group">
        <a href="/leave" class="bg-white rounded-lg p-4 shadow-sm border border-slate-100 hover:shadow-md hover:border-yellow-200 transition group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center group-hover:bg-yellow-100 transition shrink-0">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div class="min-w-0">
                    <h3 class="text-sm font-semibold text-slate-800">My Leave Records</h3>
                    <p class="text-xs text-slate-500 mt-0.5">View your leave history and apply for leave</p>
                </div>
            </div>
        </a>
        <a href="/notifications" class="bg-white rounded-lg p-4 shadow-sm border border-slate-100 hover:shadow-md hover:border-purple-200 transition group">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition shrink-0">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-semibold text-slate-800">Notifications</h3>
                        @php $dashUnread = auth()->user()->unreadNotificationsCount(); @endphp
                        @if($dashUnread > 0)
                            <span class="bg-red-500 text-white text-[10px] font-bold min-w-5 h-5 px-1.5 rounded-full flex items-center justify-center">{{ $dashUnread > 99 ? '99+' : $dashUnread }}</span>
                        @endif
                    </div>
                    <p class="text-xs text-slate-500 mt-0.5">View your notifications</p>
                </div>
            </div>
        </a>
    </div>
    @else
    <div class="bg-white rounded-lg p-6 shadow-sm border border-slate-100 text-center">
        <p class="text-slate-500">Employee profile not found. Please contact the administrator.</p>
    </div>
    @endif
</div>

{{-- Check Out Confirm Modal --}}
<div id="checkOutModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.5 2H13v-9h3a1 1 0 010 2h-1a1 1 0 000 2h2a1 1 0 010 2h-1v1zM3 17h9v-2H3v2zm0-4h7v-2H3v2zm0-4h5V7H3v2z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Check Out?</h3>
                <p class="text-sm text-slate-500 mt-0.5">Record your check-out at <span class="font-medium text-slate-700" id="checkOutTime"></span>.</p>
            </div>
        </div>
        <div class="flex flex-col gap-2.5">
            <button type="button" onclick="submitCheckOut()" class="w-full py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">
                Confirm Check Out
            </button>
            <button type="button" onclick="openIssueModal()" class="w-full py-2.5 rounded-xl bg-amber-100 text-amber-700 text-sm font-semibold hover:bg-amber-200 transition">
                I have an issue
            </button>
            <button type="button" onclick="closeCheckOutModal()" class="w-full py-2.5 rounded-xl text-slate-500 text-sm font-medium hover:bg-slate-100 transition">
                Cancel
            </button>
        </div>
    </div>
</div>

{{-- Report Issue Modal --}}
<div id="issueModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
        <div class="flex items-start gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-base font-bold text-slate-800">Report an Issue</h3>
                <p class="text-sm text-slate-500 mt-0.5">Describe your problem shortly. HR/Admin will be notified.</p>
            </div>
        </div>
        <form method="POST" action="/attendance/report-issue" id="issueForm">
            @csrf
            <textarea name="issue" rows="4" required maxlength="500"
                placeholder="e.g. I clicked check-out by mistake but I am still working..."
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500 mb-4"></textarea>
            <div class="flex gap-2.5">
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-amber-500 text-white text-sm font-semibold hover:bg-amber-600 transition">Submit Issue</button>
                <button type="button" onclick="closeIssueModal()" class="px-5 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-medium hover:bg-slate-200 transition">Cancel</button>
            </div>
        </form>
    </div>
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
            maintainAspectRatio: false,
            scales: { x: { stacked: true, grid: { display: false } }, y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } } },
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 12, boxWidth: 8, font: { size: 10 } } } }
        }
    });

    window.addEventListener('storage', function (e) {
        if (e.key === 'attendance_updated') window.location.reload();
    });
});

function openCheckOutConfirm() {
    var now = new Date();
    var time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
    document.getElementById('checkOutTime').textContent = time;
    showModal('checkOutModal');
}

function closeCheckOutModal() {
    hideModal('checkOutModal');
}

function openIssueModal() {
    hideModal('checkOutModal');
    showModal('issueModal');
}

function closeIssueModal() {
    hideModal('issueModal');
}

function submitCheckOut() {
    document.getElementById('quickCheckOutForm').submit();
}

function showModal(id) {
    var el = document.getElementById(id);
    el.classList.remove('hidden');
    el.classList.add('flex');
}

function hideModal(id) {
    var el = document.getElementById(id);
    el.classList.add('hidden');
    el.classList.remove('flex');
}

document.addEventListener('click', function (e) {
    if (e.target.id === 'issueModal') closeIssueModal();
    if (e.target.id === 'checkOutModal') closeCheckOutModal();
});
</script>
@endif
@endpush