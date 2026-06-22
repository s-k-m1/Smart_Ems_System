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
        Attendance Dashboard
    </title>

</head>

<body
    class="
        bg-[#F5F6FA]
        min-h-screen
    "
>

    <div
        class="
            max-w-[1700px]
            mx-auto
            px-8
            py-10
        "
    >

        {{-- Action Buttons --}}
        <div class="flex gap-4 mb-6">

            <a
                href="/attendance/create"
                class="
                    bg-blue-500
                    hover:bg-blue-600
                    text-white
                    px-5
                    py-2
                    rounded-xl
                    font-medium
                "
            >
                Create Attendance
            </a>

            <a
                href="/attendance/report"
                class="
                    bg-green-500
                    hover:bg-green-600
                    text-white
                    px-5
                    py-2
                    rounded-xl
                    font-medium
                "
            >
                Report
            </a>

        </div>

        @if($employee)

            {{-- Employee Profile --}}
            <div class="mb-8">

                @include(
                    'AttendanceLeave.attendance.employee-profile'
                )

            </div>

            {{-- Attendance Cards --}}
            <div class="mb-8">

                @include(
                    'AttendanceLeave.attendance.attendance-cards'
                )

            </div>

            {{-- Bottom Section --}}
            <div
                class="
                    grid
                    grid-cols-2
                    gap-8
                    items-start
                "
            >

                <div>

                    @include(
                        'AttendanceLeave.attendance.attendance-rate'
                    )

                </div>

                <div>

                    @include(
                        'AttendanceLeave.attendance.attendance-summary'
                    )

                </div>

            </div>

        @else

            <div
                class="
                    bg-white
                    rounded-[32px]
                    p-20
                    text-center
                    shadow-sm
                "
            >

                <div
                    class="
                        text-[60px]
                        mb-5
                    "
                >
                    👤
                </div>

                <h1
                    class="
                        text-4xl
                        font-semibold
                        text-slate-700
                    "
                >
                    No Employee Found
                </h1>

                <p
                    class="
                        text-gray-400
                        mt-4
                        text-lg
                    "
                >
                    Add employee records to view attendance dashboard.
                </p>

            </div>

        @endif

    </div>

</body>

</html>