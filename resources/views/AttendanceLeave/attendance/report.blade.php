@extends('CoreSystem.layouts.app')

@section('title', 'Attendance Report')

@section('content')

<div class="px-4 sm:px-8 py-4 sm:py-8"
>

    {{-- Header --}}
    <div
        class="
            flex
            flex-col
            lg:flex-row
            justify-between
            items-start
            lg:items-center
            gap-6
            mb-8
        "
    >

        <div>

            <h1
                class="
                    text-3xl
                    sm:text-4xl
                    lg:text-5xl
                    font-bold
                    text-slate-800
                "
            >
                Attendance Report
            </h1>

            <p
                class="
                    mt-2
                    text-sm
                    sm:text-base
                    text-gray-500
                "
            >
                Track and manage employee attendance records
            </p>

        </div>

        <a
            href="/attendance/create"
            class="
                w-full
                sm:w-auto
                text-center
                px-6
                py-3
                rounded-xl
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
            + Add Attendance
        </a>

    </div>

    {{-- Report Card --}}
    <div
        class="
            bg-white
            rounded-2xl
            lg:rounded-[32px]
            shadow-xl
            overflow-hidden
        "
    >

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead
                    class="
                        bg-gradient-to-r
                        from-blue-600
                        to-indigo-600
                        text-white
                    "
                >

                    <tr>

                        <th
                            class="
                                px-6
                                py-5
                                text-left
                                whitespace-nowrap
                            "
                        >
                            Employee
                        </th>

                        <th
                            class="
                                px-6
                                py-5
                                text-left
                                whitespace-nowrap
                            "
                        >
                            Status
                        </th>

                        <th
                            class="
                                px-6
                                py-5
                                text-left
                                whitespace-nowrap
                            "
                        >
                            Date
                        </th>

                        <th
                            class="
                                px-6
                                py-5
                                text-center
                                whitespace-nowrap
                            "
                        >
                            Actions
                        </th>

                    </tr>

                </thead>

                <tbody>

                @foreach($attendances as $att)

                <tr
                    class="
                        border-b
                        hover:bg-blue-50
                        transition
                    "
                >

                    {{-- Employee --}}
                    <td class="px-6 py-5">

                        <div
                            class="
                                flex
                                items-center
                                gap-4
                            "
                        >

                            <div
                                class="
                                    w-12
                                    h-12
                                    rounded-full
                                    bg-blue-100
                                    flex
                                    items-center
                                    justify-center
                                    font-bold
                                    text-blue-600
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

                    </td>
                                    {{-- Status --}}
                    <td class="px-6 py-5">

                        @if($att->status=='Present')

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    px-4
                                    py-2
                                    rounded-full
                                    bg-green-100
                                    text-green-700
                                    text-sm
                                    font-semibold
                                    whitespace-nowrap
                                "
                            >
                                ✓ Present
                            </span>

                        @elseif($att->status=='Late')

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    px-4
                                    py-2
                                    rounded-full
                                    bg-yellow-100
                                    text-yellow-700
                                    text-sm
                                    font-semibold
                                    whitespace-nowrap
                                "
                            >
                                🕒 Late
                            </span>

                        @elseif($att->status=='Undertime')

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    px-4
                                    py-2
                                    rounded-full
                                    bg-orange-100
                                    text-orange-700
                                    text-sm
                                    font-semibold
                                    whitespace-nowrap
                                "
                            >
                                ⏱ Undertime
                            </span>

                        @else

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    px-4
                                    py-2
                                    rounded-full
                                    bg-red-100
                                    text-red-700
                                    text-sm
                                    font-semibold
                                    whitespace-nowrap
                                "
                            >
                                ✕ Absent
                            </span>

                        @endif

                    </td>

                    {{-- Date --}}
                    <td
                        class="
                            px-6
                            py-5
                            whitespace-nowrap
                            text-slate-600
                            font-medium
                        "
                    >
                        {{ \Carbon\Carbon::parse($att->date)->format('M d, Y') }}
                        @if($att->date && \Carbon\Carbon::parse($att->date)->format('H:i:s') !== '00:00:00')
                            <span class="block text-xs text-slate-400">{{ \Carbon\Carbon::parse($att->date)->format('g:i A') }}</span>
                        @endif
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-5">

                        <div
                            class="
                                flex
                                flex-col
                                sm:flex-row
                                justify-center
                                gap-2
                            "
                        >

                            <a
                                href="/attendance/{{ $att->id }}/edit"
                                class="
                                    text-center
                                    px-4
                                    py-2
                                    rounded-xl
                                    bg-yellow-100
                                    text-yellow-700
                                    hover:bg-yellow-200
                                    transition
                                "
                            >
                                ✏ Edit
                            </a>

                            <form action="/attendance/{{ $att->id }}/delete" method="POST" onsubmit="return confirm('Delete this attendance record?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="
                                        text-center
                                        px-4
                                        py-2
                                        rounded-xl
                                        bg-red-100
                                        text-red-600
                                        hover:bg-red-200
                                        transition
                                        cursor-pointer
                                    "
                                >
                                    🗑 Delete
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

        </div>
                {{-- Pagination --}}
        @if(method_exists($attendances,'links'))

            <div
                class="
                    px-4
                    sm:px-6
                    lg:px-8
                    py-5
                    bg-gray-50
                    border-t
                "
            >

                <div
                    class="
                        overflow-x-auto
                    "
                >
                    {{ $attendances->links() }}
                </div>

            </div>

        @endif

    </div>

</div>

@endsection