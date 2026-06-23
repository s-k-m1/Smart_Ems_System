<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-8">

    {{-- Present --}}
    <div class="bg-white rounded-[28px] p-6 shadow-lg border border-slate-100 flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center">
            <svg class="w-7 h-7 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m16-10a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
        </div>

        <div>
            <h1 class="text-4xl font-bold text-slate-700">{{ $present }}</h1>
            <p class="text-gray-400">Present</p>
        </div>
    </div>

    {{-- Late --}}
    <div class="bg-white rounded-[28px] p-6 shadow-lg border border-slate-100 flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
            🕒
        </div>

        <div>
            <h1 class="text-4xl font-bold text-slate-700">{{ $late }}</h1>
            <p class="text-gray-400">Late</p>
        </div>
    </div>

    {{-- Undertime --}}
    <div class="bg-white rounded-[28px] p-6 shadow-lg border border-slate-100 flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
            ⏰
        </div>

        <div>
            <h1 class="text-4xl font-bold text-slate-700">{{ $undertime }}</h1>
            <p class="text-gray-400">Undertime</p>
        </div>
    </div>

    {{-- Absent --}}
    <div class="bg-white rounded-[28px] p-6 shadow-lg border border-slate-100 flex items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-2xl text-red-500">
            ✕
        </div>

        <div>
            <h1 class="text-4xl font-bold text-slate-700">{{ $absent }}</h1>
            <p class="text-gray-400">Absent</p>
        </div>
    </div>

</div>