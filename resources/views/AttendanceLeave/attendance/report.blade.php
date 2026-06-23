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
        Attendance Report
    </title>

</head>

<body
    class="
        bg-gradient-to-br
        from-slate-100
        via-blue-50
        to-indigo-100
        min-h-screen
    "
>

    <div
        class="
            max-w-7xl
            mx-auto
            p-10
        "
    >

        {{-- Header --}}
        <div
            class="
                mb-8
                flex
                justify-between
                items-center
            "
        >

            <div>

                <h1
                    class="
                        text-5xl
                        font-bold
                        text-slate-800
                    "
                >
                    Attendance Report
                </h1>

                <p
                    class="
                        text-gray-500
                        mt-2
                    "
                >
                    Track and manage employee attendance records
                </p>

            </div>

            <a
                href="/attendance/create"
                class="
                    px-8
                    py-4
                    rounded-2xl
                    bg-gradient-to-r
                    from-blue-500
                    to-indigo-600
                    text-white
                    shadow-lg
                    hover:scale-105
                    transition
                "
            >
                ＋ Add Attendance
            </a>

        </div>

        {{-- Card --}}
        <div
            class="
                bg-white/90
                backdrop-blur-lg
                rounded-[36px]
                shadow-2xl
                overflow-hidden
            "
        >

            {{-- Table Header --}}
            <div
                class="
                    bg-gradient-to-r
                    from-blue-600
                    to-indigo-600
                    text-white
                    px-10
                    py-8
                "
            >

                <div
                    class="
                        grid
                        grid-cols-4
                        font-semibold
                        text-lg
                    "
                >

                    <div>Employee</div>
                    <div>Status</div>
                    <div>Date</div>

                    <div class="text-center">
                        Action
                    </div>

                </div>

            </div>

            {{-- Rows --}}
            @foreach($attendances as $att)

                <div
                    class="
                        grid
                        grid-cols-4
                        items-center
                        px-10
                        py-8
                        border-b
                        hover:bg-blue-50
                        transition
                    "
                >

                    {{-- Employee --}}
                    <div>

                        <div
                            class="
                                flex
                                items-center
                                gap-4
                            "
                        >

                            <div
                                class="
                                    w-14
                                    h-14
                                    rounded-full
                                    bg-blue-100
                                    flex
                                    items-center
                                    justify-center
                                    text-blue-600
                                    font-bold
                                    text-lg
                                "
                            >
                                {{ strtoupper(substr($att->employee->name,0,1)) }}
                            </div>

                            <div>

                                <h2
                                    class="
                                        font-semibold
                                        text-slate-700
                                    "
                                >
                                    {{ $att->employee->name }}
                                </h2>

                                <p
                                    class="
                                        text-gray-400
                                        text-sm
                                    "
                                >
                                    Employee
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Status --}}
                    <div>

                        @if($att->status=='Present')

                            <span
                                class="
                                    px-5
                                    py-2
                                    rounded-full
                                    bg-green-100
                                    text-green-700
                                    font-semibold
                                "
                            >
                                ✓ Present
                            </span>

                        @elseif($att->status=='Late')

                            <span
                                class="
                                    px-5
                                    py-2
                                    rounded-full
                                    bg-yellow-100
                                    text-yellow-700
                                    font-semibold
                                "
                            >
                                🕒 Late
                            </span>

                        @elseif($att->status=='Undertime')

                            <span
                                class="
                                    px-5
                                    py-2
                                    rounded-full
                                    bg-orange-100
                                    text-orange-700
                                    font-semibold
                                "
                            >
                                ⏱ Undertime
                            </span>

                        @else

                            <span
                                class="
                                    px-5
                                    py-2
                                    rounded-full
                                    bg-red-100
                                    text-red-700
                                    font-semibold
                                "
                            >
                                ✕ Absent
                            </span>

                        @endif

                    </div>

                    {{-- Date --}}
                    <div
                        class="
                            text-slate-600
                            font-medium
                        "
                    >
                        {{ $att->date }}
                    </div>

                    {{-- Actions --}}
                    <div
                        class="
                            flex
                            justify-center
                            gap-4
                        "
                    >

                        <a
                            href="/attendance/{{ $att->id }}/edit"
                            class="
                                px-6
                                py-3
                                rounded-2xl
                                bg-yellow-100
                                text-yellow-700
                                hover:scale-105
                                transition
                            "
                        >
                            ✏ Edit
                        </a>

                        <a
                            href="/attendance/{{ $att->id }}/delete"
                            class="
                                px-6
                                py-3
                                rounded-2xl
                                bg-red-100
                                text-red-600
                                hover:scale-105
                                transition
                            "
                        >
                            🗑 Delete
                        </a>

                    </div>

                </div>

            @endforeach

            {{-- Pagination --}}
            @if(method_exists($attendances,'links'))

                <div
                    class="
                        p-8
                        bg-gray-50
                    "
                >
                    {{ $attendances->links() }}
                </div>

            @endif

        </div>

    </div>

</body>

</html>