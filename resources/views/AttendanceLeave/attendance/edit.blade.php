<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <script src="https://cdn.tailwindcss.com"></script>

    <title>
        Edit Attendance
    </title>

</head>

<body
    class="
        min-h-screen
        bg-gradient-to-br
        from-indigo-50
        via-slate-50
        to-blue-100
    "
>

    <div
        class="
            max-w-6xl
            mx-auto
            py-12
            px-6
        "
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

                    {{-- Status --}}
                    <div>

                        <label
                            class="
                                text-gray-500
                                block
                                mb-3
                                font-semibold
                            "
                        >
                            Attendance Status
                        </label>

                        <select
                            name="status"
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
                        >

                            <option
                                value="Present"
                                {{ $attendance->status == 'Present' ? 'selected' : '' }}
                            >
                                Present
                            </option>

                            <option
                                value="Late"
                                {{ $attendance->status == 'Late' ? 'selected' : '' }}
                            >
                                Late
                            </option>

                            <option
                                value="Undertime"
                                {{ $attendance->status == 'Undertime' ? 'selected' : '' }}
                            >
                                Undertime
                            </option>

                            <option
                                value="Absent"
                                {{ $attendance->status == 'Absent' ? 'selected' : '' }}
                            >
                                Absent
                            </option>

                        </select>

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
                        mt-10
                        bg-slate-50
                        rounded-[28px]
                        p-8
                        flex
                        justify-between
                        items-center
                    "
                >

                    <div>

                        <h3
                            class="
                                text-xl
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
                            "
                        >
                            Changes will immediately update attendance records.
                        </p>

                    </div>

                    <div class="flex gap-5">

                        <a
                            href="/attendance/report"
                            class="
                                px-8
                                py-4
                                rounded-[20px]
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
                                px-10
                                py-4
                                rounded-[20px]
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

</body>

</html>