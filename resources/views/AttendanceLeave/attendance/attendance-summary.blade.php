<div class="bg-white rounded-[32px] p-8 shadow-lg border border-slate-100">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-8">

        <h1 class="text-2xl lg:text-3xl font-bold text-slate-700">
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
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Present --}}
        <div class="h-[250px] rounded-[28px] bg-blue-100 relative overflow-hidden">

            <div class="absolute top-8 w-full text-center text-3xl font-bold text-slate-700">
                {{ $present }}
            </div>

            <div
                class="
                    absolute
                    bottom-0
                    w-full
                    bg-blue-500
                    h-[140px]
                    rounded-t-[36px]
                    text-white
                    flex
                    items-end
                    justify-center
                    pb-8
                    text-lg
                    font-semibold
                "
            >
                Present
            </div>

        </div>

        {{-- Late --}}
        <div class="h-[250px] rounded-[28px] bg-lime-100 relative overflow-hidden">

            <div class="absolute top-8 w-full text-center text-3xl font-bold text-slate-700">
                {{ $late }}
            </div>

            <div
                class="
                    absolute
                    bottom-0
                    w-full
                    bg-lime-500
                    h-[120px]
                    rounded-t-[36px]
                    text-white
                    flex
                    items-end
                    justify-center
                    pb-8
                    text-lg
                    font-semibold
                "
            >
                Late
            </div>

        </div>

        {{-- Undertime --}}
        <div class="h-[250px] rounded-[28px] bg-orange-100 relative overflow-hidden">

            <div class="absolute top-8 w-full text-center text-3xl font-bold text-slate-700">
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
                    text-lg
                    font-semibold
                "
            >
                Undertime
            </div>

        </div>

        {{-- Absent --}}
        <div class="h-[250px] rounded-[28px] bg-red-100 relative overflow-hidden">

            <div class="absolute top-8 w-full text-center text-3xl font-bold text-slate-700">
                {{ $absent }}
            </div>

            <div
                class="
                    absolute
                    bottom-0
                    w-full
                    bg-red-500
                    h-[110px]
                    rounded-t-[36px]
                    text-white
                    flex
                    items-end
                    justify-center
                    pb-8
                    text-lg
                    font-semibold
                "
            >
                Absent
            </div>

        </div>

    </div>

</div>