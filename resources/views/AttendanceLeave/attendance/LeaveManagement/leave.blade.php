@extends('CoreSystem.layouts.app')

@section('title', 'Leave Management')

@section('content')

<div class="px-4 sm:px-8 py-4 sm:py-8">

@if(session('success'))
<div class="bg-gray-200 text-gray-800 p-3 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

{{-- SUMMARY --}}
<div class="grid grid-cols-3 gap-5 mb-6">
    <div class="bg-slate-700 text-white p-5 rounded-xl">
        <p class="text-sm opacity-80">Annual Leave</p>
        <p class="text-3xl font-bold mt-1">{{ \App\Models\Leave::where('type', 'Annual')->count() }}</p>
    </div>
    <div class="bg-slate-600 text-white p-5 rounded-xl">
        <p class="text-sm opacity-80">Sick Leave</p>
        <p class="text-3xl font-bold mt-1">{{ \App\Models\Leave::where('type', 'Sick')->count() }}</p>
    </div>
    <div class="bg-slate-800 text-white p-5 rounded-xl">
        <p class="text-sm opacity-80">Total Leaves</p>
        <p class="text-3xl font-bold mt-1">{{ $history->count() }}</p>
    </div>
</div>

{{-- APPLY FORM --}}
<div class="bg-white p-6 rounded-xl shadow mb-6">
<form method="POST" action="/leave/store">
@csrf
<div class="grid grid-cols-2 gap-5">
    <div>
        <label class="text-gray-700">Leave Type</label>
        <select name="type" class="w-full border border-gray-300 p-2 rounded">
            <option>Annual</option>
            <option>Sick</option>
            <option>Casual</option>
        </select>
    </div>
    <div>
        <label class="text-gray-700">From Date</label>
        <input type="date" name="from_date" class="w-full border border-gray-300 p-2 rounded">
    </div>
    <div>
        <label class="text-gray-700">To Date</label>
        <input type="date" name="to_date" class="w-full border border-gray-300 p-2 rounded">
    </div>
    <div>
        <label class="text-gray-700">Reason</label>
        <textarea name="reason" class="w-full border border-gray-300 p-2 rounded"></textarea>
    </div>
</div>
<button class="mt-4 bg-slate-700 hover:bg-slate-900 text-white px-6 py-2 rounded">Submit</button>
</form>
</div>

{{-- LEAVE HISTORY --}}
<div class="bg-white rounded-xl shadow overflow-hidden overflow-x-auto">
<div class="bg-slate-800 p-4 text-white font-bold text-lg">Leave History</div>
<table class="w-full text-left min-w-[700px]">
<thead class="bg-gray-100">
<tr>
    @if(!auth()->user()->isEmployee())
    <th class="p-3">Employee</th>
    @endif
    <th class="p-3">Type</th>
    <th>From</th>
    <th>To</th>
    <th>Days</th>
    <th>Reason</th>
    <th>Status</th>
    @if(!auth()->user()->isEmployee())
    <th>Actions</th>
    @endif
</tr>
</thead>
<tbody>
@foreach($history as $leave)
<tr class="border-b hover:bg-gray-50">
    @if(!auth()->user()->isEmployee())
    <td class="p-3">{{ $leave->employee?->name ?? 'N/A' }}</td>
    @endif
    <td class="p-3">{{ $leave->type }}</td>
    <td>{{ $leave->from_date }}</td>
    <td>{{ $leave->to_date }}</td>
    <td>{{ $leave->days }}</td>
    <td>{{ $leave->reason }}</td>
    <td>
        @if($leave->status == 'Approved')
            <span class="text-green-500 font-medium">{{ $leave->status }}</span>
        @elseif($leave->status == 'Rejected')
            <span class="text-red-500 font-medium">{{ $leave->status }}</span>
        @else
            <span class="text-yellow-500 font-medium">{{ $leave->status }}</span>
        @endif
    </td>
    @if(!auth()->user()->isEmployee())
    <td class="p-3">
        @if($leave->status == 'Pending')
        <div class="flex gap-2">
            <form action="/leave/{{ $leave->id }}/approve" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-800 font-medium text-sm">Approve</button>
            </form>
            <form action="/leave/{{ $leave->id }}/reject" method="POST" class="inline">
                @csrf
                <button type="submit" onclick="return confirm('Reject this leave?')" class="text-red-600 hover:text-red-800 font-medium text-sm">Reject</button>
            </form>
        </div>
        @else
            <span class="text-gray-400 text-sm">—</span>
        @endif
    </td>
    @endif
</tr>
@endforeach
</tbody>
</table>
</div>

</div>
@endsection
