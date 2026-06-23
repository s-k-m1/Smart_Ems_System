<div class="bg-white rounded-[32px] p-8 shadow-lg border border-slate-100 h-full">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6">

        <div>
            <h1 class="text-[28px] lg:text-[34px] font-semibold text-slate-700">
                Attendance Rate
            </h1>

            <div class="mt-3 inline-block px-5 py-2 rounded-full bg-blue-50 text-blue-500 text-sm">
                This Year
            </div>
        </div>

        <h1 class="text-[48px] lg:text-[60px] xl:text-[72px] font-bold text-slate-700 leading-none">
            {{ $rate }}%
        </h1>

    </div>

    <hr class="my-8">

    <p class="text-gray-500 font-medium mb-8">
        Monthly Rate
    </p>

    {{-- Monthly Blocks --}}
    <div class="flex items-end gap-4 overflow-x-auto pb-4">

        @php
            $colors = [
                'bg-blue-500',
                'bg-orange-400',
                'bg-green-400',
                'bg-purple-500',
                'bg-pink-500',
                'bg-indigo-500',
            ];
        @endphp

        @foreach($monthlyAttendance as $index => $month)

            @php
                $height = max(120, $month['percentage'] * 3);
            @endphp

            <div
                class="min-w-[110px] rounded-[24px] text-white p-5 flex flex-col justify-between {{ $colors[$index % count($colors)] }}"
                style="height: {{ $height }}px"
            >

                <p class="text-sm">
                    {{ $month['month'] }}
                </p>

                <h2 class="text-2xl font-bold">
                    {{ $month['percentage'] }}%
                </h2>

            </div>

        @endforeach

    </div>

    {{-- Footer --}}
    <div class="mt-8 text-gray-400 leading-7">
        Employee monthly attendance rate highlights consistent attendance performance.
    </div>

</div>