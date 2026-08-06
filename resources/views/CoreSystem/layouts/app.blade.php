<!DOCTYPE html>
<html lang="en" class="{{ auth()->user()->theme ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Smart EMS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        };
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dark-mode.css') }}">
    @stack('styles')
</head>
<body class="bg-slate-50 min-h-screen dark:bg-slate-950 dark:text-slate-100">

    {{-- Mobile header bar --}}
    <div class="fixed top-0 left-0 right-0 z-40 lg:hidden bg-slate-900 text-white flex items-center justify-between px-4 py-3">
        <button id="mobileMenuBtn" class="p-2 rounded-lg hover:bg-slate-800 transition" aria-label="Open menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
        <a href="{{ Auth::user()->isAdmin() ? '/admin/dashboard' : (Auth::user()->isHr() ? '/hr/dashboard' : '/employee/dashboard') }}"
           class="text-lg font-bold tracking-tight">Smart EMS</a>
        <div class="w-10"></div>
    </div>

    {{-- Sidebar overlay --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-30 hidden lg:hidden opacity-0 transition-opacity duration-200"></div>

    {{-- Sidebar --}}
    @include('CoreSystem.layouts.sidebar')

    {{-- Main content --}}
    <div id="mainContent" class="lg:ml-64 min-h-screen pt-14 lg:pt-0">
        <div class="lg:pl-6 pl-4 pr-4 py-6">
            @yield('content')
        </div>
    </div>

    @stack('scripts')

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const menuBtn = document.getElementById('mobileMenuBtn');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => {
                overlay.classList.remove('opacity-0');
                overlay.classList.add('opacity-100');
            }, 10);
            document.body.classList.add('overflow-hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 200);
            document.body.classList.remove('overflow-hidden');
        }

        if (menuBtn) menuBtn.addEventListener('click', openSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar && !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });

        // Close sidebar on nav link click (mobile)
        document.querySelectorAll('#sidebar nav a').forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 1024) closeSidebar();
            });
        });
    </script>
</body>
</html>
