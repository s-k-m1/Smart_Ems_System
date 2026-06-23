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
        Create Attendance
    </title>

</head>

<body
    class="
        min-h-screen
        bg-gradient-to-br
        from-blue-50
        via-slate-50
        to-purple-50
    "
>

    <div
        class="
            max-w-5xl
            mx-auto
            py-12
            px-6
        "
    >

        <div
            class="
                bg-white/90
                backdrop-blur
                rounded-[36px]
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
                    p-10
                    text-white
                "
            >

                <h1
                    class="
                        text-5xl
                        font-bold
                    "
                >
                    Create Attendance
                </h1>

                <p
                    class="
                        mt-3
                        text-blue-100
                        text-lg
                    "
                >
                    Record employee attendance quickly and professionally
                </p>

            </div>

            <form
                action="/attendance/store"
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
                                block
                                mb-3
                                text-gray-500
                                font-medium
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

                    {{-- Status --}}
                    <div>

                        <label
                            class="
                                block
                                mb-3
                                text-gray-500
                                font-medium
                            "
                        >
                            Attendance Status
                        </label>

                        <select
                            name="status"
                            required
                            class="
                                w-full
                                rounded-3xl
                                border
                                border-gray-200
                                bg-gray-50
                                px-6
                                py-5
                                focus:ring-4
                                focus:ring-green-100
                                outline-none
                            "
                        >

                            <option>Present</option>
                            <option>Late</option>
                            <option>Undertime</option>
                            <option>Absent</option>

                        </select>

                    </div>

                    {{-- Date --}}
                    <div>

                        <label
                            class="
                                block
                                mb-3
                                text-gray-500
                                font-medium
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
                                mb-3
                                text-gray-500
                                font-medium
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
                    <div class="col-span-2">

                        <label
                            class="
                                block
                                mb-3
                                text-gray-500
                                font-medium
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
                                px-10
                                py-4
                                rounded-3xl
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

</body>

</html>