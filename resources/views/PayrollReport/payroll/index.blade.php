@extends('CoreSystem.layouts.app')

@section('title', 'Payroll Dashboard')

@section('content')
<div class="px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Payroll Dashboard
            </h1>
            <p class="text-gray-500 mt-1">
                Manage employee payrolls efficiently.
            </p>
        </div>
        <a href="/payroll/create"
           class="bg-emerald-600 hover:bg-emerald-700 transition text-white px-6 py-3 rounded-xl font-semibold shadow-lg">
            + Generate Payroll
        </a>
    </div>

    @if(session('success'))
    <div class="mb-5 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-700">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8 mb-10">
        <div class="bg-gradient-to-br from-pink-500 via-pink-600 to-rose-600 rounded-2xl shadow-xl p-6 text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <div class="flex justify-center">
                <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center shadow">
                    <i class="fa-solid fa-users text-pink-600 text-2xl"></i>
                </div>
            </div>
            <div class="mt-6 text-center">
                <h1 class="text-5xl font-extrabold">{{ $totalEmployees }}</h1>
                <h2 class="text-xl font-semibold mt-4">Employees</h2>
            </div>
        </div>
        <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 rounded-2xl shadow-xl p-6 text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <div class="flex justify-center">
                <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center shadow">
                    <i class="fa-solid fa-file-invoice-dollar text-blue-600 text-2xl"></i>
                </div>
            </div>
            <div class="mt-6 text-center">
                <h1 class="text-5xl font-extrabold">{{ $totalPayrolls }}</h1>
                <h2 class="text-xl font-semibold mt-4">Payrolls</h2>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-500 via-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <div class="flex justify-center">
                <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center shadow">
                    <i class="fa-solid fa-circle-check text-green-600 text-2xl"></i>
                </div>
            </div>
            <div class="mt-6 text-center">
                <h1 class="text-5xl font-extrabold">{{ $paidPayrolls }}</h1>
                <h2 class="text-xl font-semibold mt-4">Paid Payrolls</h2>
            </div>
        </div>
        <div class="bg-gradient-to-br from-orange-400 via-orange-500 to-amber-600 rounded-2xl shadow-xl p-6 text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <div class="flex justify-center">
                <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center shadow">
                    <i class="fa-solid fa-clock text-orange-500 text-2xl"></i>
                </div>
            </div>
            <div class="mt-6 text-center">
                <h1 class="text-5xl font-extrabold">{{ $pendingPayrolls }}</h1>
                <h2 class="text-xl font-semibold mt-4">Pending Payrolls</h2>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-3 text-left">Employee</th>
                    <th class="p-3 text-left">Month</th>
                    <th class="p-3 text-left">Year</th>
                    <th class="p-3 text-left">Bonus</th>
                    <th class="p-3 text-left">Deduction</th>
                    <th class="p-3 text-left">Net Salary</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payrolls as $payroll)
                <tr class="border-b">
                    <td class="p-3">{{ $payroll->employee->name }}</td>
                    <td class="p-3">{{ $payroll->month }}</td>
                    <td class="p-3">{{ $payroll->year }}</td>
                    <td class="p-3">{{ $payroll->bonus }}</td>
                    <td class="p-3">{{ $payroll->leave_deduction }}</td>
                    <td class="p-3">{{ $payroll->net_salary }}</td>
                    <td class="p-3">
                        @if($payroll->status == 'Pending')
                        <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Pending
                        </span>
                        @else
                        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                            Paid
                        </span>
                        @endif
                    </td>
                    <td class="p-3">
                        <div class="flex justify-center items-center gap-2">
                            @if($payroll->status == 'Pending')
                            <form action="{{ route('payroll.paid', $payroll->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-10 h-10 bg-green-600 hover:bg-green-700 rounded-lg text-white transition">
                                    <i class="fa-solid fa-check"></i>
                                </button>
                            </form>
                            @endif
                            <a href="{{ route('payroll.edit', $payroll->id) }}"
                               class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-lg text-white flex items-center justify-center transition">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('payroll.destroy', $payroll->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this payroll?');">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="w-10 h-10 bg-red-600 hover:bg-red-700 rounded-lg text-white transition">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection