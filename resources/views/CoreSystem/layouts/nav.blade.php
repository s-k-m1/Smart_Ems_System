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
                        <a href="/notifications" class="text-slate-600 hover:text-slate-800 transition">Notifications</a>
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
