@extends('CoreSystem.layouts.app')

@section('title', 'Create Attendance')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-6">

        {{-- Page header --}}
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-slate-500 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div>
                    <h1 class="text-lg font-semibold text-slate-900 dark:text-white leading-tight">Create Attendance</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Record employee attendance</p>
                </div>
            </div>
            <a href="/attendance" class="text-sm text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 transition font-medium">
                &larr; Back
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 px-4 py-3">
                <ul class="list-disc list-inside text-xs text-red-600 dark:text-red-300 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/attendance/store" method="POST"
              class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">

            @csrf

            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-sm font-semibold text-slate-700 dark:text-slate-200">Attendance Details</h2>
            </div>

            <div class="px-6 py-6 grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">

                {{-- Employee --}}
                <div>
                    <label class="block mb-1.5 text-[13px] font-medium text-slate-500 dark:text-slate-400">
                        Employee
                    </label>

                    @if($employee)
                        {{-- Employees can only record attendance for themselves --}}
                        <input type="hidden" name="employee_id" value="{{ $employee->id }}">
                        <div class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 px-3.5 py-2.5 text-sm text-slate-500 dark:text-slate-300 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $employee->name }}
                        </div>
                    @else
                        <select name="employee_id" required
                                class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-400 transition">
                            <option value="">Choose Employee</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>

                {{-- Date --}}
                <div>
                    <label class="block mb-1.5 text-[13px] font-medium text-slate-500 dark:text-slate-400">
                        Attendance Date
                    </label>
                    <input type="date" name="date" required
                           value="{{ date('Y-m-d') }}"
                           min="{{ $minDate ?? date('Y-m-d') }}"
                           max="{{ $maxDate ?? date('Y-m-d') }}"
                           class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-400 transition" />
                </div>

                {{-- Check In --}}
                <div>
                    <label class="block mb-1.5 text-[13px] font-medium text-slate-500 dark:text-slate-400">
                        Check In
                    </label>
                    <input type="time" name="check_in"
                           class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-200 dark:text-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-400 transition" />
                </div>

                {{-- Check Out --}}
                <div>
                    <label class="block mb-1.5 text-[13px] font-medium text-slate-500 dark:text-slate-400">
                        Check Out
                    </label>
                    <input type="time" name="check_out"
                           class="w-full rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-200 dark:text-slate-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-200 dark:focus:ring-indigo-800 focus:border-indigo-400 transition" />
                </div>

                {{-- Auto detected status note --}}
                <div class="md:col-span-2">
                    <div class="rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-4 py-3 flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-slate-400 dark:text-slate-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                            Status is detected automatically from clock times — <span class="font-medium text-slate-600 dark:text-slate-300">Absent</span> (no check-in),
                            <span class="font-medium text-slate-600 dark:text-slate-300">Undertime</span> (under 7h or incomplete),
                            <span class="font-medium text-slate-600 dark:text-slate-300">Late</span> (after 9:00 AM),
                            <span class="font-medium text-slate-600 dark:text-slate-300">Present</span> otherwise.
                        </p>
                    </div>
                </div>

            </div>

            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
                <p class="text-xs text-slate-400 dark:text-slate-500 hidden sm:block">
                    Attendance will be stored and shown in reports.
                </p>
                <div class="flex items-center gap-2 ml-auto">
                    <a href="/attendance"
                       class="px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        Cancel
                    </a>
                    <button type="submit"
                            class="px-5 py-2 rounded-lg bg-slate-900 dark:bg-indigo-600 text-white text-sm font-medium hover:bg-slate-700 dark:hover:bg-indigo-500 shadow-sm transition">
                        Save Attendance
                    </button>
                </div>
            </div>

        </form>
    </div>
@endsection

@push('scripts')
@if(session('success') || session('error'))
<script>localStorage.setItem('attendance_updated', Date.now());</script>
@endif
@endpush