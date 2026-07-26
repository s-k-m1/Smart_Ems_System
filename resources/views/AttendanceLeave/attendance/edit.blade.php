@extends('CoreSystem.layouts.app')

@section('title', 'Edit Attendance')

@section('content')

    <div class="px-4 sm:px-8 py-4 sm:py-8"
    >

        <div
            class="
                bg-white
                rounded-[40px]
                overflow-hidden
                shadow-2xl
            "
        >

            {{-- Header --}}
            <div
                class="
                    bg-gradient-to-r
                    from-indigo-600
                    to-blue-500
                    p-10
                    text-white
                "
            >

                <div class="flex justify-between items-center">

                    <div>

                        <h1
                            class="
                                text-5xl
                                font-bold
                            "
                        >
                            Edit Attendance
                        </h1>

                        <p
                            class="
                                mt-3
                                text-blue-100
                                text-lg
                            "
                        >
                            Modify attendance information
                        </p>

                    </div>

                    <div
                        class="
                            w-24
                            h-24
                            rounded-full
                            bg-white/20
                            flex
                            items-center
                            justify-center
                            text-5xl
                        "
                    >
                        ✏️
                    </div>

                </div>

            </div>

            <form
                action="/attendance/{{ $attendance->id }}/update"
                method="POST"
                class="p-10"
            >

                @csrf

                <div
                    class="
                        grid
                        grid-cols-2
                        gap-8
                    "
                >

                    {{-- Employee --}}
                    <div>

                        <label
                            class="
                                text-gray-500
                                block
                                mb-3
                                font-semibold
                            "
                        >
                            Employee
                        </label>

                        <select
                            name="employee_id"
                            required
                            class="
                                w-full
                                rounded-[24px]
                                border
                                border-gray-200
                                bg-slate-50
                                px-6
                                py-5
                                focus:ring-4
                                focus:ring-indigo-100
                                outline-none
                            "
                        >

                            @foreach($employees as $employee)

                                <option
                                    value="{{ $employee->id }}"
                                    {{ $attendance->employee_id == $employee->id ? 'selected' : '' }}
                                >
                                    {{ $employee->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Auto Status Info --}}
                    <div>

                        <div class="bg-indigo-50 rounded-[24px] px-6 py-5 border border-indigo-100">
                            <p class="text-sm text-indigo-700 font-medium">Status Auto-Detected</p>
                            <p class="text-xs text-indigo-500 mt-1">Current: <strong>{{ $attendance->status }}</strong>. Will be recalculated from check-in/check-out on save.</p>
                        </div>

                    </div>

                    {{-- Date --}}
                    <div>

                        <label
                            class="
                                text-gray-500
                                block
                                mb-3
                                font-semibold
                            "
                        >
                            Attendance Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            value="{{ $attendance->date }}"
                            required
                            class="
                                w-full
                                rounded-[24px]
                                border
                                border-gray-200
                                bg-slate-50
                                px-6
                                py-5
                            "
                        />

                    </div>

                    {{-- Check In --}}
                    <div>

                        <label
                            class="
                                text-gray-500
                                block
                                mb-3
                                font-semibold
                            "
                        >
                            Check In
                        </label>

                        <input
                            type="time"
                            name="check_in"
                            value="{{ $attendance->check_in }}"
                            class="
                                w-full
                                rounded-[24px]
                                border
                                border-gray-200
                                bg-slate-50
                                px-6
                                py-5
                            "
                        />

                    </div>

                    {{-- Check Out --}}
                    <div class="col-span-2">

                        <label
                            class="
                                text-gray-500
                                block
                                mb-3
                                font-semibold
                            "
                        >
                            Check Out
                        </label>

                        <input
                            type="time"
                            name="check_out"
                            value="{{ $attendance->check_out }}"
                            class="
                                w-full
                                rounded-[24px]
                                border
                                border-gray-200
                                bg-slate-50
                                px-6
                                py-5
                            "
                        />

                    </div>

                </div>

              {{-- Bottom Area --}}
                <div
                    class="
                        mt-8
                        bg-slate-50
                        rounded-2xl
                        p-5
                        sm:p-6
                        lg:p-8
                        flex
                        flex-col
                        lg:flex-row
                        justify-between
                        items-start
                        lg:items-center
                        gap-6
                    "
                >

                    <div class="w-full lg:w-auto">

                        <h3
                            class="
                                text-lg
                                sm:text-xl
                                font-semibold
                                text-slate-700
                            "
                        >
                            Update Employee Attendance
                        </h3>

                        <p
                            class="
                                text-gray-400
                                mt-2
                                text-sm
                                sm:text-base
                            "
                        >
                            Changes will immediately update attendance records.
                        </p>

                    </div>

                    <div
                        class="
                            flex
                            flex-col
                            sm:flex-row
                            gap-3
                            w-full
                            lg:w-auto
                        "
                    >

                        <a
                            href="/attendance/report"
                            class="
                                w-full
                                sm:w-auto
                                text-center
                                px-6
                                py-3
                                rounded-xl
                                bg-white
                                shadow
                                hover:shadow-lg
                                transition
                            "
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="
                                w-full
                                sm:w-auto
                                whitespace-nowrap
                                px-6
                                py-3
                                rounded-xl
                                bg-gradient-to-r
                                from-indigo-600
                                to-blue-500
                                text-white
                                font-semibold
                                shadow-lg
                                hover:scale-105
                                transition
                            "
                        >
                            Update Attendance
                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

@endsection

@push('scripts')
@if(session('success') || session('error'))
<script>localStorage.setItem('attendance_updated', Date.now());</script>
@endif
@endpush