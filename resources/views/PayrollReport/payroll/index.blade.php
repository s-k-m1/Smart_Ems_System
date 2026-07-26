@extends('CoreSystem.layouts.app')

@section('title', 'Payroll')

@section('content')
<div class="px-4 sm:px-8 py-4 sm:py-8">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">Payroll</h1>
            <p class="text-slate-500 text-sm mt-1">Manage employee salary records</p>
        </div>
        <a href="{{ route('payroll.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition text-center sm:w-auto">
            + New Payroll
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden overflow-x-auto">
        <table class="w-full text-sm min-w-[700px]">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-4 sm:px-5 py-3.5 font-semibold text-slate-700">Employee</th>
                    <th class="text-left px-4 sm:px-5 py-3.5 font-semibold text-slate-700">Month</th>
                    <th class="text-right px-4 sm:px-5 py-3.5 font-semibold text-slate-700">Basic</th>
                    <th class="text-right px-4 sm:px-5 py-3.5 font-semibold text-slate-700">Allowances</th>
                    <th class="text-right px-4 sm:px-5 py-3.5 font-semibold text-slate-700">Deductions</th>
                    <th class="text-right px-4 sm:px-5 py-3.5 font-semibold text-slate-700">Net Pay</th>
                    <th class="text-center px-4 sm:px-5 py-3.5 font-semibold text-slate-700">Status</th>
                    <th class="text-center px-4 sm:px-5 py-3.5 font-semibold text-slate-700">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($payrolls as $p)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-4 sm:px-5 py-4">
                        <a href="{{ route('payroll.show', $p) }}" class="text-blue-600 hover:underline font-medium">
                            {{ $p->employee->name }}
                        </a>
                        <p class="text-xs text-slate-400">{{ $p->employee->employee_id }}</p>
                    </td>
                    <td class="px-4 sm:px-5 py-4 text-slate-700 whitespace-nowrap">{{ \Carbon\Carbon::parse($p->month . '-01')->format('M Y') }}</td>
                    <td class="px-4 sm:px-5 py-4 text-right text-slate-700 whitespace-nowrap">Rs. {{ number_format($p->basic_salary, 2) }}</td>
                    <td class="px-4 sm:px-5 py-4 text-right text-slate-700 whitespace-nowrap">Rs. {{ number_format($p->allowances, 2) }}</td>
                    <td class="px-4 sm:px-5 py-4 text-right text-slate-700 whitespace-nowrap">Rs. {{ number_format($p->deductions, 2) }}</td>
                    <td class="px-4 sm:px-5 py-4 text-right font-semibold text-slate-800 whitespace-nowrap">Rs. {{ number_format($p->net_pay, 2) }}</td>
                    <td class="px-4 sm:px-5 py-4 text-center">
                        @if($p->status === 'paid')
                            <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2.5 py-1 rounded-full">Paid</span>
                        @elseif($p->status === 'pending')
                            <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-full">Pending</span>
                        @else
                            <span class="inline-block bg-red-100 text-red-700 text-xs font-medium px-2.5 py-1 rounded-full">Cancelled</span>
                        @endif
                    </td>
                    <td class="px-4 sm:px-5 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('payroll.edit', $p) }}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">Edit</a>
                            <form action="{{ route('payroll.destroy', $p) }}" method="POST" onsubmit="return confirm('Delete this payroll record?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-sm font-medium">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-5 py-12 text-center text-slate-400">
                        No payroll records found.
                        <a href="{{ route('payroll.create') }}" class="text-blue-500 hover:underline block mt-2">Create the first payroll entry</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $payrolls->links() }}
    </div>

</div>
@endsection
