@extends('CoreSystem.layouts.app')

@section('title', 'Attendance Dashboard')

@section('content')

<div class="px-4 sm:px-8 py-4 sm:py-8">

    {{-- Action Buttons + Employee Selector --}}
    <div
        class="
            flex
            flex-wrap
            items-center
            gap-4
            mb-8
        "
    >
        @if(!auth()->user()->isEmployee())
        <a
            href="/attendance/create"
            class="
                bg-blue-500
                hover:bg-blue-600
                text-white
                px-6
                py-3
                rounded-2xl
                font-semibold
                transition
            "
        >
            Create Attendance
        </a>

        <a
            href="/attendance/report"
            class="
                bg-green-500
                hover:bg-green-600
                text-white
                px-6
                py-3
                rounded-2xl
                font-semibold
                transition
            "
        >
            Report
        </a>
        @endif

        @if($employeesForSelect->isNotEmpty())
        <div class="ml-auto">
            <select id="employeeSelect" onchange="window.location.href='/attendance?employee='+this.value"
                class="rounded-2xl border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-blue-200">
                @foreach($employeesForSelect as $emp)
                    <option value="{{ $emp->id }}" {{ $emp->id === $employee?->id ? 'selected' : '' }}>
                        {{ $emp->name }} ({{ $emp->employee_id }})
                    </option>
                @endforeach
            </select>
        </div>
        @endif

    </div>

    @if(session('success'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-green-100 text-green-700 text-sm font-medium">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 px-4 py-3 rounded-xl bg-red-100 text-red-700 text-sm font-medium">{{ session('error') }}</div>
    @endif

     {{-- Check In / Check Out Quick Actions --}}
     @if(auth()->user()->isEmployee() && $employee)
     <div class="mb-8">
         <div class="bg-gradient-to-r from-slate-50 to-white rounded-2xl shadow-sm border border-slate-100 p-4 sm:p-5">
             <div class="flex items-center justify-between mb-3">
                 <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Quick Attendance</h3>
                 <span class="text-[10px] text-slate-400">{{ now()->format('M d, Y') }}</span>
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
                   <div class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 text-slate-400 text-xs font-semibold">
                       <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                       Check-in starts at 9:00 AM
                   </div>
                   @endif
                   @endif
             </div>
         </div>
     </div>
     @endif

    @if($employee)

        {{-- Employee Profile --}}
        <div class="mb-8">

            @include(
                'AttendanceLeave.attendance.employee-profile'
            )

        </div>

        {{-- Attendance Cards --}}
        <div class="mb-8">

            @include(
                'AttendanceLeave.attendance.attendance-cards'
            )

        </div>

       {{-- Dashboard Row 1 --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">

    {{-- Attendance Rate --}}
    <div>
        @include('AttendanceLeave.attendance.attendance-rate')
    </div>

    {{-- Weekly Summary --}}
    <div class="bg-white rounded-[32px] p-8 shadow-lg border border-slate-100">

        <h2 class="text-3xl font-bold text-slate-700 mb-8">
            Weekly Summary
        </h2>

        @foreach($weeklySummary as $day)

            <div class="mb-8">

                <div class="flex justify-between mb-3">

                    <span class="font-medium text-slate-700">
                        {{ $day['day'] }}
                    </span>

                    <span class="text-gray-500">
                        {{ $day['present'] }}%
                    </span>

                </div>

                <div class="w-full h-4 bg-gray-200 rounded-full">

                    <div
                        class="h-4 bg-green-500 rounded-full"
                        style="width: {{ $day['present'] }}%"
                    ></div>

                </div>

            </div>

        @endforeach

    </div>

</div>

{{-- Dashboard Row 2 --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

    {{-- Working Hours --}}
    <div class="bg-white rounded-[32px] p-8 shadow-lg border border-slate-100">

        <h2 class="text-3xl font-bold text-slate-700 mb-8">
            Working Hours
        </h2>

        <div class="text-[80px] font-bold text-blue-600">
            {{ number_format($currentMonthHours,1) }}
        </div>

        <p class="text-gray-500 text-xl mt-4">
            Target: {{ $monthlyWorkingHours }} Hours / Month
        </p>

        <div class="mt-8">

            <div class="w-full h-5 bg-gray-200 rounded-full">

                <div
                    class="h-5 bg-blue-500 rounded-full"
                    style="
                        width:
                        {{ min(($currentMonthHours / $monthlyWorkingHours) * 100, 100) }}%;
                    "
                ></div>

            </div>

        </div>

    </div>

    {{-- Company Policy --}}
    <div class="bg-white rounded-[32px] p-8 shadow-lg border border-slate-100">

        <h2 class="text-3xl font-bold text-slate-700 mb-8">
            Company Policy
        </h2>

        <div class="space-y-10">

            <div>

                <p class="text-gray-500 mb-2">
                    Annual Leave
                </p>

                <div class="text-[70px] font-bold text-green-600">
                    {{ $annualLeaves }}
                </div>

                <p class="text-gray-400">
                    Days Per Year
                </p>

            </div>

            <div>

                <p class="text-gray-500 mb-2">
                    Weekly Holiday
                </p>

                <div class="text-4xl font-bold text-slate-700">
                    {{ $weeklyHoliday }}
                </div>

            </div>

        </div>

    </div>

 @endif

@if(auth()->user()->isEmployee())
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
@endif

@endsection

@push('scripts')
@if(session('success') || session('error'))
<script>localStorage.setItem('attendance_updated', Date.now());</script>
@endif
@if(auth()->user()->isEmployee())
<script>
function openCheckOutConfirm() {
    var now = new Date();
    document.getElementById('checkOutTime').textContent = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
    showModal('checkOutModal');
}
function closeCheckOutModal() { hideModal('checkOutModal'); }
function openIssueModal() { hideModal('checkOutModal'); showModal('issueModal'); }
function closeIssueModal() { hideModal('issueModal'); }
function submitCheckOut() { document.getElementById('quickCheckOutForm').submit(); }
function showModal(id) { var el = document.getElementById(id); el.classList.remove('hidden'); el.classList.add('flex'); }
function hideModal(id) { var el = document.getElementById(id); el.classList.add('hidden'); el.classList.remove('flex'); }
document.addEventListener('click', function (e) {
    if (e.target.id === 'issueModal') closeIssueModal();
    if (e.target.id === 'checkOutModal') closeCheckOutModal();
});
</script>
@endif
@endpush