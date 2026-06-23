<div
    class="
        bg-white
        rounded-[34px]
        p-10
        shadow-sm
    "
>

    {{-- Title --}}
    <h1
        class="
            text-[34px]
            font-semibold
            text-slate-700
            mb-10
        "
    >
        Employee Details
    </h1>

    <div
        class="
            flex
            items-center
            gap-10
        "
    >

        {{-- Avatar --}}
        <div
            class="
                w-28
                h-28
                rounded-full
                overflow-hidden
                bg-blue-50
                shrink-0
            "
        >

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode($employee->name) }}&background=e8f1ff&color=1e40af&size=180"
                class="
                    w-full
                    h-full
                    object-cover
                "
            />

        </div>

        {{-- Name --}}
        <div class="min-w-[220px]">

            <h2
                class="
                    text-[42px]
                    font-semibold
                    text-slate-700
                "
            >
                {{ $employee->name }}
            </h2>

            <div
                class="
                    text-gray-400
                    text-sm
                    mt-3
                "
            >
                Employee
            </div>

        </div>

        {{-- Details --}}
        <div
            class="
                grid
                grid-cols-4
                gap-14
                flex-1
            "
        >

            <div>

                <p
                    class="
                        text-green-400
                        text-lg
                        mb-2
                    "
                >
                    ID
                </p>

                <p
                    class="
                        text-xl
                        font-semibold
                        text-slate-700
                    "
                >
                    {{ $employee->employee_id }}
                </p>

            </div>

            <div>

                <p
                    class="
                        text-green-400
                        text-lg
                        mb-2
                    "
                >
                    Phone
                </p>

                <p
                    class="
                        text-xl
                        font-semibold
                        text-slate-700
                    "
                >
                    {{ $employee->phone }}
                </p>

            </div>

            <div>

                <p
                    class="
                        text-green-400
                        text-lg
                        mb-2
                    "
                >
                    Email
                </p>

                <p
                    class="
                        text-xl
                        font-semibold
                        text-slate-700
                        break-all
                    "
                >
                    {{ $employee->email }}
                </p>

            </div>

            <div>

                <p
                    class="
                        text-green-400
                        text-lg
                        mb-2
                    "
                >
                    Department
                </p>

                <p
                    class="
                        text-xl
                        font-semibold
                        text-slate-700
                    "
                >
                    {{ $employee->department }}
                </p>

            </div>

        </div>

    </div>

</div>