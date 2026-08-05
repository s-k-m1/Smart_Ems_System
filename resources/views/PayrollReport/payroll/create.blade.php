@extends('CoreSystem.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                {{ isset($payroll) ? 'Edit Payroll' : 'Generate Payroll' }}
            </h1>
            <p class="text-gray-500 mt-1">
                {{ isset($payroll)
    ? 'Update payroll details for the selected employee.'
    : 'Generate monthly salary for an employee.' }}
            </p>
        </div>
        <a href="/payroll" class="px-5 py-3 bg-gray-200 rounded-lg hover:bg-gray-300 font-medium">
            ← Payroll Dashboard
        </a>
    </div>
    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg p-10">
        @if(isset($payroll))
        <form action="{{ route('payroll.update',$payroll->id) }}" method="POST">
            @csrf
            @method('PUT')

            @else
            <form action="/payroll" method="POST">
                @csrf
                @endif
                <div class="grid grid-cols-2 gap-8">
                    <!-- Employee -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Employee

                        </label>
                        <select name="employee_id" class="w-full rounded-xl border border-gray-300 px-4 py-3" required>

                            @if(!isset($payroll))
                            <option value="" selected disabled>Select Employee</option>
                            @endif

                            @foreach($employees as $employee)

                            <option
                                value="{{ $employee->id }}"
                                {{ old('employee_id', $payroll->employee_id ?? '') == $employee->id ? 'selected' : '' }}>

                                {{ $employee->name }}

                            </option>

                            @endforeach

                        </select>
                    </div>
                    <!-- Month -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Month
                        </label>
                        @php
                        $months = [
                        'January','February','March','April','May','June',
                        'July','August','September','October','November','December'
                        ];
                        @endphp

                        <select name="month" class="w-full rounded-xl border border-gray-300 px-4 py-3">

                            @foreach($months as $month)

                            <option
                                value="{{ $month }}"
                                {{ old('month', $payroll->month ?? date('F')) == $month ? 'selected' : '' }}>

                                {{ $month }}

                            </option>

                            @endforeach

                        </select>
                    </div>
                    <!-- year -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Year
                        </label>
                        <input
                            type="number"
                            name="year"
                            value="{{ old('year', $payroll->year ?? date('Y')) }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3">
                    </div>
                    <!-- Bonus -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Bonus
                        </label>
                        <input
                            type="number"
                            name="bonus"
                            value="{{ old('bonus', $payroll->bonus ?? 0) }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3">
                    </div>
                    <!-- Leave -->
                    <div>
                        <label class="block mb-2 font-semibold text-gray-700">
                            Unpaid Leave Days
                        </label>
                        <input
                            type="number"
                            name="unpaid_leave_days"
                            value="{{ old('unpaid_leave_days', $payroll->unpaid_leave_days ?? 0) }}"
                            class="w-full rounded-xl border border-gray-300 px-4 py-3">
                    </div>
                </div>
                <div class="border-t mt-10 pt-8 flex justify-end gap-4">
                    <a href="/payroll" class="px-6 py-3 rounded-xl bg-gray-300 hover:bg-gray-400">
                        Cancel

                    </a>
                    <button type="submit" class="px-8 py-3 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-semibold">
                        {{ isset($payroll) ? 'Update Payroll' : 'Generate Payroll' }} </button>
                </div>
            </form>
    </div>
</div>

@endsection