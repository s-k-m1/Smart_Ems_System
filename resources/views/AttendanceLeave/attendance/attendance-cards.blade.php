<div class="grid grid-cols-4 gap-6 mt-8">

    {{-- Present --}}
    <div class="bg-white rounded-[28px] px-8 py-6 shadow-sm flex items-center gap-5">

        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
            <svg
                class="w-6 h-6 text-blue-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16-10a4 4 0 11-8 0 4 4 0 018 0z"
                />
            </svg>
        </div>

        <div>
            <h1 class="text-[40px] font-semibold text-slate-700">
                {{ $present }}
            </h1>

            <p class="text-gray-400">
                Total Attendance
            </p>
        </div>

    </div>

    {{-- Late --}}
    <div class="bg-white rounded-[28px] px-8 py-6 shadow-sm flex items-center gap-5">

        <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
            🕒
        </div>

        <div>
            <h1 class="text-[40px] font-semibold">
                {{ $late }}
            </h1>

            <p class="text-gray-400">
                Late Attendance
            </p>
        </div>

    </div>

    {{-- Undertime --}}
    <div class="bg-white rounded-[28px] px-8 py-6 shadow-sm flex items-center gap-5">

        <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">
            ⏰
        </div>

        <div>
            <h1 class="text-[40px] font-semibold">
                {{ $undertime }}
            </h1>

            <p class="text-gray-400">
                Undertime Attendance
            </p>
        </div>

    </div>

    {{-- Absent --}}
    <div class="bg-white rounded-[28px] px-8 py-6 shadow-sm flex items-center gap-5">

        <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
            ✕
        </div>

        <div>
            <h1 class="text-[40px] font-semibold">
                {{ $absent }}
            </h1>

            <p class="text-gray-400">
                Total Absent
            </p>
        </div>

    </div>

</div>