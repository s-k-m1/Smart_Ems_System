@extends('CoreSystem.layouts.app')

@section('title', 'Edit Payroll')

@section('content')
<div class="px-4 sm:px-8 py-4 sm:py-8 max-w-3xl">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Edit Payroll</h1>
        <p class="text-slate-500 text-sm mt-1">Update salary record for {{ $payroll->employee->name }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

        <form action="{{ route('payroll.update', $payroll) }}" method="POST">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-6">

                <div class="col-span-2">
                    <label class="block font-medium text-sm text-slate-700 mb-1.5">Employee</label>
                    <select name="employee_id" class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm" required>
                        @foreach($employees as $emp)
                            <option value="{{ $emp->id }}" {{ old('employee_id', $payroll->employee_id) == $emp->id ? 'selected' : '' }}>
                                {{ $emp->name }} ({{ $emp->employee_id }})
                            </option>
                        @endforeach
                    </select>
                    @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium text-sm text-slate-700 mb-1.5">Month</label>
                    <input type="month" name="month" value="{{ old('month', $payroll->month) }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm" required>
                    @error('month') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium text-sm text-slate-700 mb-1.5">Status</label>
                    <select name="status" class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm" required>
                        <option value="pending" {{ old('status', $payroll->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="paid" {{ old('status', $payroll->status) === 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="cancelled" {{ old('status', $payroll->status) === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium text-sm text-slate-700 mb-1.5">Basic Salary (Rs.)</label>
                    <input type="number" step="0.01" min="0" name="basic_salary"
                           value="{{ old('basic_salary', $payroll->basic_salary) }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm" required>
                    @error('basic_salary') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium text-sm text-slate-700 mb-1.5">Allowances (Rs.)</label>
                    <input type="number" step="0.01" min="0" name="allowances"
                           value="{{ old('allowances', $payroll->allowances) }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm" required>
                    @error('allowances') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium text-sm text-slate-700 mb-1.5">Deductions (Rs.)</label>
                    <input type="number" step="0.01" min="0" name="deductions"
                           value="{{ old('deductions', $payroll->deductions) }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm" required>
                    @error('deductions') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium text-sm text-slate-700 mb-1.5">Net Pay (Rs.)</label>
                    <input type="number" step="0.01" min="0" name="net_pay"
                           value="{{ old('net_pay', $payroll->net_pay) }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm" required>
                    @error('net_pay') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block font-medium text-sm text-slate-700 mb-1.5">Payment Date</label>
                    <input type="date" name="payment_date"
                           value="{{ old('payment_date', $payroll->payment_date?->format('Y-m-d')) }}"
                           class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm">
                    @error('payment_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="col-span-2">
                    <label class="block font-medium text-sm text-slate-700 mb-1.5">Notes</label>
                    <textarea name="notes" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2.5 text-sm"
                              placeholder="Optional notes...">{{ old('notes', $payroll->notes) }}</textarea>
                    @error('notes') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

            </div>

            <div class="flex items-center gap-3 mt-8 pt-6 border-t border-slate-200">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                    Update Payroll
                </button>
                <a href="{{ route('payroll.index') }}" class="text-slate-600 hover:text-slate-800 text-sm font-medium transition">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>
@endsection
