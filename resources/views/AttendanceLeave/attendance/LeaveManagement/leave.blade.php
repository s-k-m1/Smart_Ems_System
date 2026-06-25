<!DOCTYPE html>
<html>
<head>
    <title>Leave Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-7xl mx-auto p-8">

<!-- SUCCESS MESSAGE -->
@if(session('success'))
<div class="bg-green-200 text-green-800 p-3 mb-4 rounded">
    {{ session('success') }}
</div>
@endif

<!-- SUMMARY (static UI for now) -->
<div class="grid grid-cols-3 gap-5 mb-6">

    <div class="bg-pink-600 text-white p-5 rounded-xl">
        Annual Leave
    </div>

    <div class="bg-green-600 text-white p-5 rounded-xl">
        Sick Leave
    </div>

    <div class="bg-blue-600 text-white p-5 rounded-xl">
        Total Leaves
    </div>

</div>

<!-- APPLY FORM -->
<div class="bg-white p-6 rounded-xl shadow mb-6">

<form method="POST" action="/leave/store">
@csrf

<div class="grid grid-cols-2 gap-5">

    <div>
        <label>Leave Type</label>
        <select name="type" class="w-full border p-2 rounded">
            <option>Annual</option>
            <option>Sick</option>
            <option>Casual</option>
        </select>
    </div>

    <div>
        <label>From Date</label>
        <input type="date" name="from_date" class="w-full border p-2 rounded">
    </div>

    <div>
        <label>To Date</label>
        <input type="date" name="to_date" class="w-full border p-2 rounded">
    </div>

    <div>
        <label>Reason</label>
        <textarea name="reason" class="w-full border p-2 rounded"></textarea>
    </div>

</div>

<button class="mt-4 bg-green-500 text-white px-6 py-2 rounded">
Submit
</button>

</form>

</div>

<!-- LEAVE HISTORY (DYNAMIC) -->
<div class="bg-white rounded-xl shadow overflow-hidden">

<!-- YOUR COLORED HEADER -->
<div class="bg-indigo-600 p-4 text-white font-bold text-lg">
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
<tr class="border-b">

    <td class="p-3">{{ $leave->id }}</td>
    <td>{{ $leave->type }}</td>
    <td>{{ $leave->from_date }}</td>
    <td>{{ $leave->to_date }}</td>
    <td>{{ $leave->days }}</td>
    <td>{{ $leave->reason }}</td>

    <td>
        @if($leave->status == 'Approved')
            <span class="text-green-600">{{ $leave->status }}</span>
        @else
            <span class="text-yellow-600">{{ $leave->status }}</span>
        @endif
    </td>

</tr>
@endforeach

</tbody>

</table>

</div>

</div>

</body>
</html>