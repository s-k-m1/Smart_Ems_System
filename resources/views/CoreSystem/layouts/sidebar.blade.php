<aside id="sidebar"
       class="fixed inset-y-0 left-0 w-64 bg-slate-900 text-white flex flex-col z-50
              -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">
    <div class="px-6 py-5 border-b border-slate-700 flex items-center justify-between">
        <a href="{{ Auth::user()->isAdmin() ? '/admin/dashboard' : (Auth::user()->isHr() ? '/hr/dashboard' : '/employee/dashboard') }}"
           class="text-xl font-bold tracking-tight">Smart EMS</a>
        <button id="sidebarCloseBtn" class="lg:hidden p-1 rounded-lg hover:bg-slate-800 transition text-slate-400 hover:text-white" aria-label="Close menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
        <a href="{{ Auth::user()->isAdmin() ? '/admin/dashboard' : (Auth::user()->isHr() ? '/hr/dashboard' : '/employee/dashboard') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('admin/dashboard') || request()->is('hr/dashboard') || request()->is('employee/dashboard') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Dashboard
        </a>

        @if(Auth::user()->hasAnyPermission(['manage_employees', 'view_employees']))
        <a href="/employees"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('employees*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            Employees
        </a>
        @endif

        @if(Auth::user()->hasAnyPermission(['manage_attendance', 'view_attendance']))
        <a href="/attendance"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('attendance*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
            Attendance
        </a>
        @endif

        @if(Auth::user()->hasAnyPermission(['manage_leave', 'view_leave']))
        <a href="/leave"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('leave*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Leave
        </a>
        @endif

        @if(Auth::user()->hasAnyPermission(['manage_notifications', 'view_notifications']))
        <a href="/notifications"
           class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('notifications*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            <span class="flex-1">Notifications</span>
            @php $navUnread = auth()->user()->unreadNotificationsCount(); @endphp
            @if($navUnread > 0)
                <span class="shrink-0 bg-red-500 text-white text-[10px] font-bold min-w-5 h-5 px-1.5 rounded-full flex items-center justify-center">
                    {{ $navUnread > 99 ? '99+' : $navUnread }}
                </span>
            @endif
        </a>
        @endif

        @if(Auth::user()->hasAnyPermission(['manage_payroll', 'view_payroll']))
        <a href="/payroll"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('payroll*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            Payroll
        </a>
        @endif

        @if(Auth::user()->hasAnyPermission(['view_reports', 'manage_reports']))
        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">Administration</p>
        </div>
        <a href="/report"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('report*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Reports
        </a>
        @endif

        <div class="pt-4 pb-2">
            <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-500">General</p>
        </div>
        <a href="/settings"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->is('settings*') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }} transition">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Settings
        </a>
    </nav>

    <div class="px-4 py-4 border-t border-slate-700">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-slate-600 flex items-center justify-center text-sm font-medium shrink-0">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-400 capitalize truncate">{{ Auth::user()->role }}</p>
            </div>
            <button type="button" id="sidebarThemeBtn"
                    class="text-slate-400 hover:text-white transition shrink-0 p-1 rounded-lg hover:bg-slate-800"
                    title="Toggle dark/light mode">
                <svg id="sidebarIconSun" class="w-5 h-5 {{ auth()->user()->theme === 'dark' ? 'hidden' : '' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <svg id="sidebarIconMoon" class="w-5 h-5 {{ auth()->user()->theme === 'dark' ? '' : 'hidden' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
            </button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-slate-400 hover:text-white transition shrink-0" title="Logout">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var closeBtn = document.getElementById('sidebarCloseBtn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                var sidebar = document.getElementById('sidebar');
                var overlay = document.getElementById('sidebarOverlay');
                if (sidebar && overlay) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.remove('opacity-100');
                    overlay.classList.add('opacity-0');
                    setTimeout(function() { overlay.classList.add('hidden'); }, 200);
                    document.body.classList.remove('overflow-hidden');
                }
            });
        }

        var sidebarThemeBtn = document.getElementById('sidebarThemeBtn');
        if (sidebarThemeBtn) {
            sidebarThemeBtn.addEventListener('click', function() {
                var isDark = document.documentElement.classList.contains('dark');
                var next = isDark ? 'light' : 'dark';
                document.documentElement.classList.toggle('dark', next === 'dark');
                document.getElementById('sidebarIconSun').classList.toggle('hidden', next === 'dark');
                document.getElementById('sidebarIconMoon').classList.toggle('hidden', next !== 'dark');
                fetch('{{ route('settings.theme') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ theme: next })
                });
            });
        }
    });
</script>
