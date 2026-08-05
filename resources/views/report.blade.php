@extends('CoreSystem.layouts.app')

@section('title', 'Reports')

@section('content')
<header class="bg-white border-b border-slate-200 px-4 sm:px-8 py-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">Reports</h1>
            <p class="text-sm text-slate-500 mt-0.5">Attendance and employee distribution overview</p>
        </div>
        <span class="text-xs text-slate-400">{{ now()->format('l, F j, Y') }}</span>
    </div>
</header>

<div class="px-4 sm:px-8 py-4 sm:py-8">

    <div class="flex gap-2 mb-4">
        <a href="{{ route('report.index', ['tab' => 'attendance']) }}"
           class="tab-btn px-4 py-2 rounded {{ request('tab', 'attendance') === 'attendance' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
            Attendance
        </a>
        <a href="{{ route('report.index', ['tab' => 'distribution']) }}"
           class="tab-btn px-4 py-2 rounded {{ request('tab', 'attendance') === 'distribution' ? 'bg-blue-600 text-white' : 'bg-gray-200' }}">
            Distribution
        </a>
    </div>

    @if(request('tab', 'attendance') === 'attendance')
    <section>

        @if($attendancePaginated)
        <div class="bg-white p-4 rounded mb-4">
            <p class="text-gray-500 text-sm">Showing {{ $attendancePaginated->firstItem() }}–{{ $attendancePaginated->lastItem() }} of {{ $attendancePaginated->total() }} results</p>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div class="bg-white p-4 rounded">
                <p class="text-gray-500 text-sm">Total</p>
                <p class="text-xl font-bold">{{ $attendanceSummary['total'] }}</p>
            </div>
            <div class="bg-white p-4 rounded">
                <p class="text-gray-500 text-sm">Present</p>
                <p class="text-xl font-bold text-green-600">{{ $attendanceSummary['present'] }}</p>
            </div>
            <div class="bg-white p-4 rounded">
                <p class="text-gray-500 text-sm">Absent</p>
                <p class="text-xl font-bold text-red-600">{{ $attendanceSummary['absent'] }}</p>
            </div>
            <div class="bg-white p-4 rounded">
                <p class="text-gray-500 text-sm">Leave</p>
                <p class="text-xl font-bold text-yellow-600">{{ $attendanceSummary['leave'] }}</p>
            </div>
        </div>

        <div class="bg-white p-4 rounded mb-4">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="p-3">Name</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendanceData as $row)
                    <tr>
                        <td class="p-3 border-t">{{ $row['name'] }}</td>
                        <td class="p-3 border-t">{{ $row['date'] }}</td>
                        <td class="p-3 border-t">{{ $row['status'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $attendancePaginated->links() }}
        </div>

        @else
        <div class="bg-white p-6 rounded text-center text-gray-500">
            <p>Select filters above and click Search to view attendance reports.</p>
        </div>
        @endif

        <div class="bg-white p-4 rounded">
            <form method="GET" action="{{ route('report.index') }}" class="flex flex-wrap gap-4">
                <input type="hidden" name="tab" value="attendance">
                <div>
                    <label class="block text-sm text-gray-500">From</label>
                    <input type="date" name="att_from" value="{{ request('att_from') }}" class="border p-2 rounded">
                </div>
                <div>
                    <label class="block text-sm text-gray-500">To</label>
                    <input type="date" name="att_to" value="{{ request('att_to') }}" class="border p-2 rounded">
                </div>
                <div>
                    <label class="block text-sm text-gray-500">Employee</label>
                    <select name="att_employee" class="border p-2 rounded">
                        <option value="">All Employees</option>
                        @foreach ($attendanceEmployees as $employee)
                            <option value="{{ $employee }}" {{ request('att_employee') === $employee ? 'selected' : '' }}>{{ $employee }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-500">Status</label>
                    <select name="att_status" class="border p-2 rounded">
                        <option value="">All</option>
                        <option value="Present" {{ request('att_status') === 'Present' ? 'selected' : '' }}>Present</option>
                        <option value="Absent" {{ request('att_status') === 'Absent' ? 'selected' : '' }}>Absent</option>
                        <option value="Leave" {{ request('att_status') === 'Leave' ? 'selected' : '' }}>Leave</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-500">Search</label>
                    <input type="text" name="att_search" value="{{ request('att_search') }}" placeholder="Search by name..." class="border p-2 rounded">
                </div>
                <div class="flex gap-2 self-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
                    <a href="{{ route('report.index', ['tab' => 'attendance']) }}" class="bg-gray-200 px-4 py-2 rounded">Reset</a>
                </div>
            </form>
        </div>
    </section>
    @endif

    @if(request('tab', 'attendance') === 'distribution')
    <section>

        @if($distributionPaginated)
        <div class="bg-white p-4 rounded mb-4">
            <p class="text-gray-500 text-sm">Showing {{ $distributionPaginated->firstItem() }}–{{ $distributionPaginated->lastItem() }} of {{ $distributionPaginated->total() }} results</p>
        </div>

        <div class="bg-white p-4 rounded mb-4">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="p-3">Name</th>
                        <th class="p-3">Department</th>
                        <th class="p-3">Designation</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($distributionData as $row)
                    <tr>
                        <td class="p-3 border-t">{{ $row['name'] }}</td>
                        <td class="p-3 border-t">{{ $row['department'] }}</td>
                        <td class="p-3 border-t">{{ $row['designation'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $distributionPaginated->links() }}
        </div>

        @else
        <div class="bg-white p-6 rounded text-center text-gray-500">
            <p>Select filters above and click Search to view distribution reports.</p>
        </div>
        @endif

        <div class="bg-white p-4 rounded">
            <form method="GET" action="{{ route('report.index') }}" class="flex flex-wrap gap-4">
                <input type="hidden" name="tab" value="distribution">
                <div>
                    <label class="block text-sm text-gray-500">Department</label>
                    <select name="dist_dept" class="border p-2 rounded">
                        <option value="">All Departments</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept }}" {{ request('dist_dept') === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-500">Search</label>
                    <input type="text" name="dist_search" value="{{ request('dist_search') }}" placeholder="Search by name..." class="border p-2 rounded">
                </div>
                <div class="flex gap-2 self-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Search</button>
                    <a href="{{ route('report.index', ['tab' => 'distribution']) }}" class="bg-gray-200 px-4 py-2 rounded">Reset</a>
                </div>
            </form>
        </div>
    </section>
    @endif

</div>
@endsection