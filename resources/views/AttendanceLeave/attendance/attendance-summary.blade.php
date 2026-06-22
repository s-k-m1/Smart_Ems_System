<div
    class="
        bg-white
        rounded-[32px]
        p-8
        shadow-sm
    "
>

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">

        <h1
            class="
                text-[34px]
                font-semibold
                text-slate-700
            "
        >
            Summary - {{ $employee->name }}
        </h1>

        <button
            class="
                w-10
                h-10
                rounded-full
                bg-gray-100
                text-gray-500
            "
        >
            •••
        </button>

    </div>

    {{-- Cards --}}
    <div
        class="
            grid
            grid-cols-4
            gap-5
        "
    >

        {{-- Present --}}
        <div
            class="
                h-[330px]
                rounded-[28px]
                bg-blue-100
                relative
                overflow-hidden
            "
        >

            <div
                class="
                    absolute
                    top-8
                    w-full
                    text-center
                    text-[42px]
                    font-bold
                    text-slate-700
                "
            >
                {{ $present }}
            </div>

            <div
                class="
                    absolute
                    bottom-0
                    w-full
                    bg-blue-500
                    h-[180px]
                    rounded-t-[36px]
                    text-white
                    flex
                    items-end
                    justify-center
                    pb-8
                    text-xl
                "
            >
                Attendance
            </div>

        </div>

        {{-- Late --}}
        <div
            class="
                h-[330px]
                rounded-[28px]
                bg-lime-100
                relative
                overflow-hidden
            "
        >

            <div
                class="
                    absolute
                    top-8
                    w-full
                    text-center
                    text-[42px]
                    font-bold
                    text-slate-700
                "
            >
                {{ $late }}
            </div>

            <div
                class="
                    absolute
                    bottom-0
                    w-full
                    bg-lime-500
                    h-[140px]
                    rounded-t-[36px]
                    text-white
                    flex
                    items-end
                    justify-center
                    pb-8
                    text-xl
                "
            >
                Late
            </div>

        </div>

        {{-- Undertime --}}
        <div
            class="
                h-[330px]
                rounded-[28px]
                bg-orange-50
                relative
                overflow-hidden
            "
        >

            <div
                class="
                    absolute
                    top-8
                    w-full
                    text-center
                    text-[42px]
                    font-bold
                    text-slate-700
                "
            >
                {{ $undertime }}
            </div>

            <div
                class="
                    absolute
                    bottom-0
                    w-full
                    bg-yellow-400
                    h-[90px]
                    rounded-t-[36px]
                    text-white
                    flex
                    items-end
                    justify-center
                    pb-8
                    text-xl
                "
            >
                Undertime
            </div>

        </div>

        {{-- Absent --}}
        <div
            class="
                h-[330px]
                rounded-[28px]
                bg-red-100
                relative
                overflow-hidden
            "
        >

            <div
                class="
                    absolute
                    top-8
                    w-full
                    text-center
                    text-[42px]
                    font-bold
                    text-slate-700
                "
            >
                {{ $absent }}
            </div>

            <div
                class="
                    absolute
                    bottom-0
                    w-full
                    bg-red-500
                    h-[120px]
                    rounded-t-[36px]
                    text-white
                    flex
                    items-end
                    justify-center
                    pb-8
                    text-xl
                "
            >
                Absent
            </div>

        </div>

    </div>

</div>