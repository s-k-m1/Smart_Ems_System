@extends('CoreSystem.layouts.app')

@section('title', 'Payroll - ' . $payroll->employee->name)

@section('content')
<div class="px-8 py-8 max-w-3xl">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Payroll Details</h1>
            <p class="text-slate-500 text-sm mt-1">{{ $payroll->employee->name }} — {{ \Carbon\Carbon::parse($payroll->month . '-01')->format('F Y') }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('payroll.edit', $payroll) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                Edit
            </a>
            <a href="{{ route('payroll.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <p class="text-sm text-slate-500">Employee</p>
                <p class="font-semibold text-slate-800">{{ $payroll->employee->name }}</p>
                <p class="text-xs text-slate-400">{{ $payroll->employee->employee_id }} · {{ $payroll->employee->department }}</p>
            </div>
            <div>
                @if($payroll->status === 'paid')
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-3 py-1.5 rounded-full">Paid</span>
                @elseif($payroll->status === 'pending')
                    <span class="inline-block bg-yellow-100 text-yellow-700 text-xs font-medium px-3 py-1.5 rounded-full">Pending</span>
                @else
                    <span class="inline-block bg-red-100 text-red-700 text-xs font-medium px-3 py-1.5 rounded-full">Cancelled</span>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-2 gap-0 divide-x divide-slate-100">

            <div class="px-8 py-6 space-y-4">
                <div>
                    <p class="text-sm text-slate-500">Basic Salary</p>
                    <p class="text-lg font-semibold text-slate-800">Rs. {{ number_format($payroll->basic_salary, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Allowances</p>
                    <p class="text-lg font-semibold text-green-600">+ Rs. {{ number_format($payroll->allowances, 2) }}</p>
                </div>
            </div>

            <div class="px-8 py-6 space-y-4">
                <div>
                    <p class="text-sm text-slate-500">Deductions</p>
                    <p class="text-lg font-semibold text-red-600">- Rs. {{ number_format($payroll->deductions, 2) }}</p>
                </div>
                <div>
                    <p class="text-sm text-slate-500">Net Pay</p>
                    <p class="text-2xl font-bold text-slate-800">Rs. {{ number_format($payroll->net_pay, 2) }}</p>
                </div>
            </div>

        </div>

        @if($payroll->payment_date)
        <div class="px-8 py-4 border-t border-slate-100 bg-slate-50">
            <p class="text-sm text-slate-500">Payment Date: <span class="font-medium text-slate-700">{{ $payroll->payment_date->format('F d, Y') }}</span></p>
        </div>
        @endif

        @if($payroll->notes)
        <div class="px-8 py-4 border-t border-slate-100">
            <p class="text-sm text-slate-500 mb-1">Notes</p>
            <p class="text-sm text-slate-700">{{ $payroll->notes }}</p>
        </div>
        @endif

    </div>

</div>
@endsection
