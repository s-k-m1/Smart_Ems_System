<nav class="bg-white border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <a href="{{ Auth::user()->isAdmin() ? '/admin/dashboard' : (Auth::user()->isHr() ? '/hr/dashboard' : '/employee/dashboard') }}"
               class="text-xl font-bold text-slate-800">Smart EMS</a>
<div class="hidden md:flex items-center gap-4 text-sm">
                    @if(Auth::user()->hasAnyPermission(['manage_employees', 'view_employees']))
                        <a href="/employees" class="text-slate-600 hover:text-slate-800 transition">Employees</a>
                    @endif
                    @if(Auth::user()->hasAnyPermission(['manage_attendance', 'view_attendance']))
                        <a href="/attendance" class="text-slate-600 hover:text-slate-800 transition">Attendance</a>
                    @endif
                    @if(Auth::user()->hasAnyPermission(['manage_leave', 'view_leave']))
                        <a href="/leave" class="text-slate-600 hover:text-slate-800 transition">Leave</a>
                    @endif
                    @if(Auth::user()->hasAnyPermission(['manage_notifications', 'view_notifications']))
                        <a href="/notifications" class="relative text-slate-600 hover:text-slate-800 transition flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.4-1.4A2 2 0 0118 14.17V11a6 6 0 10-12 0v3.17c0 .53-.21 1.04-.59 1.42L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            <span class="hidden lg:inline">Notifications</span>
                            @php $navUnread = auth()->user()->unreadNotificationsCount(); @endphp
                            @if($navUnread > 0)
                                <span class="absolute -top-1.5 -left-2 lg:static lg:ml-1 bg-red-500 text-white text-[10px] font-bold min-w-4 h-4 px-1 rounded-full flex items-center justify-center">
                                    {{ $navUnread > 99 ? '99+' : $navUnread }}
                                </span>
                            @endif
                        </a>
                    @endif
                    @if(Auth::user()->hasAnyPermission(['manage_payroll', 'view_payroll']))
                        <a href="/payroll" class="text-slate-600 hover:text-slate-800 transition">Payroll</a>
                    @endif
                    @if(Auth::user()->hasAnyPermission(['view_reports', 'manage_reports']))
                        <a href="/report" class="text-slate-600 hover:text-slate-800 transition">Reports</a>
                    @endif
                </div>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm text-slate-500">
                {{ Auth::user()->name }}
                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                    {{ Auth::user()->isAdmin() ? 'bg-red-100 text-red-700' : (Auth::user()->isHr() ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }}">
                    {{ ucfirst(Auth::user()->role) }}
                </span>
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-500 hover:text-slate-700 transition">Logout</button>
            </form>
        </div>
    </div>
</nav>
