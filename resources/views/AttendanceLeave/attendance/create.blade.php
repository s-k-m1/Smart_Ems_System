@extends('CoreSystem.layouts.app')

@section('title', 'Create Attendance')

@section('content')

    <div class="px-4 sm:px-8 py-4 sm:py-8
        "
    >

        <div
            class="
                bg-white/90
                backdrop-blur
                rounded-2xl
                lg:rounded-[36px]
                shadow-xl
                overflow-hidden
            "
        >

            {{-- Header --}}
            <div
                class="
                    bg-gradient-to-r
                    from-blue-500
                    to-indigo-600
                    p-5
                    sm:p-8
                    lg:p-10
                    text-white
                "
            >

                <h1
                    class="
                        text-3xl
                        sm:text-4xl
                        lg:text-5xl
                        font-bold
                    "
                >
                    Create Attendance
                </h1>

                <p
                    class="
                        mt-3
                        text-blue-100
                        text-sm
                        sm:text-base
                        lg:text-lg
                    "
                >
                    Record employee attendance quickly and professionally
                </p>

            </div>

            @if ($errors->any())
                <div class="p-4 sm:p-10 pb-0">
                    <div class="px-4 py-3 rounded-xl bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form
                action="/attendance/store"
                method="POST"
                class="p-10"
            >

                @csrf

                <div
                    class="
                        grid
                        grid-cols-1
                        md:grid-cols-2
                        gap-5
                        lg:gap-8
                >

                    {{-- Employee --}}
                    <div>

                        <label
                            class="
                                block
                                mb-2
                                text-gray-500
                                font-semibold
                                text-sm
                                sm:text-base
                            "
                        >
                            Employee
                        </label>

                        <select
                            name="employee_id"
                            required
                            class="
                                w-full
                                rounded-3xl
                                border
                                border-gray-200
                                bg-gray-50
                                px-6
                                py-5
                                focus:outline-none
                                focus:ring-4
                                focus:ring-blue-100
                            "
                        >

                            <option value="">
                                Choose Employee
                            </option>

                            @foreach($employees as $employee)

                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }}
                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- Auto Status Info --}}
                    <div>

                        <div class="bg-blue-50 rounded-3xl px-6 py-5 border border-blue-100">
                            <p class="text-sm text-blue-700 font-medium">Status Auto-Detected</p>
                            <p class="text-xs text-blue-500 mt-1">Status is determined automatically from check-in/check-out times. Absent if no check-in, Undertime if &lt;7h or incomplete, Late if after 9:00 AM, Present otherwise.</p>
                        </div>

                    </div>

                    {{-- Date --}}
                    <div>

                        <label
                            class="
                                block
                                mb-2
                                text-gray-500
                                font-semibold
                                text-sm
                                sm:text-base
                                                            "
                        >
                            Attendance Date
                        </label>

                        <input
                            type="date"
                            name="date"
                            required
                            class="
                                w-full
                                rounded-3xl
                                border
                                border-gray-200
                                bg-gray-50
                                px-6
                                py-5
                            "
                        />

                    </div>

                    {{-- Check In --}}
                    <div>

                        <label
                            class="
                                block
                                mb-2
                                text-gray-500
                                font-semibold
                                text-sm
                                sm:text-base
                                "
                        >
                            Check In
                        </label>

                        <input
                            type="time"
                            name="check_in"
                            class="
                                w-full
                                rounded-3xl
                                border
                                border-gray-200
                                bg-gray-50
                                px-6
                                py-5
                            "
                        />

                    </div>

                    {{-- Check Out --}}
                    <div class="md:col-span-2">

                        <label
                            class="
                                block
                                mb-2
                                text-gray-500
                                font-semibold
                                text-sm
                                sm:text-base
                            "
                        >
                            Check Out
                        </label>

                        <input
                            type="time"
                            name="check_out"
                            class="
                                w-full
                                rounded-3xl
                                border
                                border-gray-200
                                bg-gray-50
                                px-6
                                py-5
                            "
                        />

                    </div>

                </div>

                {{-- Decorative Bottom Section --}}
                <div
                    class="
                        mt-12
                        flex
                        justify-between
                        items-center
                    "
                >

                    <div>

                        <p
                            class="
                                text-gray-400
                                text-sm
                            "
                        >
                            Employee attendance will be stored in database
                        </p>

                    </div>

                    <div class="flex gap-5">

                        <a
                            href="/attendance"
                            class="
                                px-8
                                py-4
                                rounded-3xl
                                bg-gray-100
                                hover:bg-gray-200
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
                                px-6
                                py-3
                                rounded-2xl
                                bg-gradient-to-r
                                from-blue-500
                                to-indigo-600
                                text-white
                                font-semibold
                                shadow-lg
                                hover:scale-105
                                transition
                            "
                        >
                            Save Attendance
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