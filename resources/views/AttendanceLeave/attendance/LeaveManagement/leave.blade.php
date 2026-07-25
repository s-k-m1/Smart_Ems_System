@extends('CoreSystem.layouts.app')

@section('title', 'Leave Management')

@section('content')

<div class="px-8 py-8">

<!-- SUCCESS MESSAGE -->
@if(session('success'))
<div class="bg-gray-200 text-gray-800 p-3 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

<!-- SUMMARY -->
<div class="grid grid-cols-3 gap-5 mb-6">

    <div class="bg-slate-700 text-white p-5 rounded-xl">
        Annual Leave
    </div>

    <div class="bg-slate-600 text-white p-5 rounded-xl">
        Sick Leave
    </div>

    <div class="bg-slate-800 text-white p-5 rounded-xl">
        Total Leaves
    </div>

</div>

<!-- APPLY FORM -->
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

<button class="mt-4 bg-slate-700 hover:bg-slate-900 text-white px-6 py-2 rounded">
    Submit
</button>

</form>

</div>

<!-- LEAVE HISTORY -->
<div class="bg-white rounded-xl shadow overflow-hidden">

<!-- HEADER -->
<div class="bg-slate-800 p-4 text-white font-bold text-lg">
    Leave History
</div>

<table class="w-full text-left">

<thead class="bg-gray-100">
<tr>
    <th class="p-3">ID</th>
    <th>Type</th>
    <th>From</th>
    <th>To</th>
    <th>Days</th>
    <th>Reason</th>
    <th>Status</th>
</tr>
</thead>

<tbody>

@foreach($history as $leave)
<tr class="border-b hover:bg-gray-50">

    <td class="p-3">{{ $leave->id }}</td>
    <td>{{ $leave->type }}</td>
    <td>{{ $leave->from_date }}</td>
    <td>{{ $leave->to_date }}</td>
    <td>{{ $leave->days }}</td>
    <td>{{ $leave->reason }}</td>

    <td>
        @if($leave->status == 'Approved')
            <span class="text-green-500 font-medium">
                {{ $leave->status }}
            </span>
        @elseif($leave->status == 'Rejected')
            <span class="text-red-500 font-medium">
                {{ $leave->status }}
            </span>
        @else
            <span class="text-yellow-500 font-medium">
                {{ $leave->status }}
            </span>
        @endif
    </td>

</tr>
@endforeach

</tbody>

</table>

</div>

@endsection