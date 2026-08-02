<div class="bg-white rounded-2xl shadow-sm border border-slate-200">

    <!-- Header -->
    <div class="px-6 py-5 border-b border-slate-100">

        <h3 class="text-lg font-semibold text-slate-800">

            Quick Actions

        </h3>

        <p class="text-sm text-slate-500 mt-1">

            Frequently used notification actions

        </p>

    </div>

    <!-- Body -->
    <div class="p-6 space-y-4">

        <!-- Create Notice -->
        <a href="{{ route('notifications.create') }}"
           class="group flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:bg-blue-50 hover:border-blue-500 transition">

            <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center group-hover:bg-blue-600 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-blue-600 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 4v16m8-8H4"/>

                </svg>

            </div>

            <div>

                <h4 class="font-semibold text-slate-800">

                    Create Notice

                </h4>

                <p class="text-sm text-slate-500">

                    Publish a new announcement

                </p>

            </div>

        </a>

        <!-- Manage Notices -->
        <a href="{{ route('notifications.index') }}"
           class="group flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:bg-green-50 hover:border-green-500 transition">

            <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center group-hover:bg-green-600 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-green-600 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V9m-5-4h5v5M10 14L21 3"/>

                </svg>

            </div>

            <div>

                <h4 class="font-semibold text-slate-800">

                    Manage Notices

                </h4>

                <p class="text-sm text-slate-500">

                    View, or delete notices

                </p>

            </div>

        </a>

        <!-- Pinned Notices -->
        <a href="{{ route('notifications.index',['filter'=>'pinned']) }}"
           class="group flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:bg-amber-50 hover:border-amber-500 transition">

            <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center group-hover:bg-amber-500 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-amber-600 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 3l14 9-14 9V3z"/>

                </svg>

            </div>

            <div>

                <h4 class="font-semibold text-slate-800">

                    Pinned Notices

                </h4>

                <p class="text-sm text-slate-500">

                    View all important announcements

                </p>

            </div>

        </a>

        <!-- Notification Settings -->
        <a href="#"
           class="group flex items-center gap-4 p-4 rounded-xl border border-slate-200 hover:bg-purple-50 hover:border-purple-500 transition">

            <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center group-hover:bg-purple-600 transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-purple-600 group-hover:text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0-6v2m0 16v2m10-10h-2M4 12H2m15.07 7.07l-1.41-1.41M8.34 8.34L6.93 6.93m10.14 0l-1.41 1.41M8.34 15.66l-1.41 1.41"/>

                </svg>

            </div>

            <div>

                <h4 class="font-semibold text-slate-800">

                    Notification Settings

                </h4>

                <p class="text-sm text-slate-500">

                    Configure notification preferences

                </p>

            </div>

        </a>

    </div>

</div>