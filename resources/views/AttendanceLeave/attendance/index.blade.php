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
        font-sans
    "
>

<div
    class="
        max-w-[1700px]
        mx-auto
        px-6
        lg:px-8
        py-10
    "
>

    {{-- Action Buttons --}}
    <div
        class="
            flex
            flex-wrap
            gap-4
            mb-8
        "
    >

        <a
            href="/attendance/create"
            class="
                bg-blue-500
                hover:bg-blue-600
                text-white
                px-6
                py-3
                rounded-2xl
                font-semibold
                transition
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
                px-6
                py-3
                rounded-2xl
                font-semibold
                transition
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

       {{-- Dashboard Row 1 --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-8">

    {{-- Attendance Rate --}}
    <div>
        @include('AttendanceLeave.attendance.attendance-rate')
    </div>

    {{-- Weekly Summary --}}
    <div class="bg-white rounded-[32px] p-8 shadow-lg border border-slate-100">

        <h2 class="text-3xl font-bold text-slate-700 mb-8">
            Weekly Summary
        </h2>

        @foreach($weeklySummary as $day)

            <div class="mb-8">

                <div class="flex justify-between mb-3">

                    <span class="font-medium text-slate-700">
                        {{ $day['day'] }}
                    </span>

                    <span class="text-gray-500">
                        {{ $day['present'] }}%
                    </span>

                </div>

                <div class="w-full h-4 bg-gray-200 rounded-full">

                    <div
                        class="h-4 bg-green-500 rounded-full"
                        style="width: {{ $day['present'] }}%"
                    ></div>

                </div>

            </div>

        @endforeach

    </div>

</div>

{{-- Dashboard Row 2 --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-8">

    {{-- Working Hours --}}
    <div class="bg-white rounded-[32px] p-8 shadow-lg border border-slate-100">

        <h2 class="text-3xl font-bold text-slate-700 mb-8">
            Working Hours
        </h2>

        <div class="text-[80px] font-bold text-blue-600">
            {{ number_format($currentMonthHours,1) }}
        </div>

        <p class="text-gray-500 text-xl mt-4">
            Target: {{ $monthlyWorkingHours }} Hours / Month
        </p>

        <div class="mt-8">

            <div class="w-full h-5 bg-gray-200 rounded-full">

                <div
                    class="h-5 bg-blue-500 rounded-full"
                    style="
                        width:
                        {{ min(($currentMonthHours / $monthlyWorkingHours) * 100, 100) }}%;
                    "
                ></div>

            </div>

        </div>

    </div>

    {{-- Company Policy --}}
    <div class="bg-white rounded-[32px] p-8 shadow-lg border border-slate-100">

        <h2 class="text-3xl font-bold text-slate-700 mb-8">
            Company Policy
        </h2>

        <div class="space-y-10">

            <div>

                <p class="text-gray-500 mb-2">
                    Annual Leave
                </p>

                <div class="text-[70px] font-bold text-green-600">
                    {{ $annualLeaves }}
                </div>

                <p class="text-gray-400">
                    Days Per Year
                </p>

            </div>

            <div>

                <p class="text-gray-500 mb-2">
                    Weekly Holiday
                </p>

                <div class="text-4xl font-bold text-slate-700">
                    {{ $weeklyHoliday }}
                </div>

            </div>

        </div>

    </div>

 @endif

</div>
</body>

</html>