@extends('CoreSystem.layouts.app')

@section('title', 'Settings - Smart EMS')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 rounded-lg bg-slate-900 dark:bg-slate-800 text-white flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Settings</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Manage your account preferences</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Appearance</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Choose how Smart EMS looks on your device</p>
        </div>

        <div class="px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-300 flex items-center justify-center shrink-0">
                    @if(auth()->user()->theme === 'dark')
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                    @else
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    @endif
                </div>
                <div>
                    <p class="font-medium text-slate-900 dark:text-white">Dark Mode</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400" id="themeLabel">
                        {{ auth()->user()->theme === 'dark' ? 'Currently using dark theme' : 'Currently using light theme' }}
                    </p>
                </div>
            </div>

            <form id="themeForm" method="POST" action="{{ route('settings.theme') }}">
                @csrf
                <input type="hidden" name="theme" id="themeInput" value="{{ auth()->user()->theme }}">
                <button type="button" id="themeToggle" role="switch" aria-checked="{{ auth()->user()->theme === 'dark' ? 'true' : 'false' }}"
                        class="relative flex items-center h-9 w-16 rounded-full p-1 cursor-pointer overflow-hidden shadow-inner ring-1 ring-black/5 transition-all duration-300
                               focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900
                               {{ auth()->user()->theme === 'dark' ? 'bg-gradient-to-r from-indigo-600 via-indigo-500 to-purple-600 shadow-indigo-950/50' : 'bg-gradient-to-r from-amber-300 via-orange-200 to-sky-300 shadow-amber-400/40' }}">
                    <span id="trackIconSun" class="absolute left-1.5 text-amber-500 {{ auth()->user()->theme === 'dark' ? 'opacity-30' : 'opacity-100' }} transition-opacity duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </span>
                    <span id="trackIconMoon" class="absolute right-1.5 text-indigo-200 {{ auth()->user()->theme === 'dark' ? 'opacity-100' : 'opacity-30' }} transition-opacity duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                    </span>
                    <span id="themeKnob"
                          class="relative z-10 flex items-center justify-center w-7 h-7 rounded-full bg-white shadow-md transform transition-transform duration-300 ease-in-out {{ auth()->user()->theme === 'dark' ? 'translate-x-7' : 'translate-x-0' }}">
                        <span id="knobIconSun" class="text-amber-500 {{ auth()->user()->theme === 'dark' ? 'hidden' : '' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </span>
                        <span id="knobIconMoon" class="text-indigo-600 {{ auth()->user()->theme === 'dark' ? '' : 'hidden' }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                        </span>
                    </span>
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Help & Support</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Get assistance with Smart EMS</p>
        </div>

        <div class="px-6 py-5 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-sky-50 dark:bg-sky-900/40 text-sky-600 dark:text-sky-300 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <p class="font-medium text-slate-900 dark:text-white">Need help?</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Find answers, guides and support information</p>
                </div>
            </div>

            <button id="helpBtn"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-medium hover:bg-slate-700 dark:hover:bg-slate-200 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Help
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
            <h2 class="text-lg font-semibold text-slate-900 dark:text-white">Account</h2>
        </div>
        <div class="px-6 py-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-700 dark:text-white text-sm font-medium shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-medium text-slate-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400 truncate">{{ auth()->user()->email }}</p>
            </div>
            <span class="text-xs font-medium capitalize px-2.5 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">{{ auth()->user()->role }}</span>
        </div>
    </div>
</div>

{{-- Help modal --}}
<div id="helpModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div id="helpOverlay" class="absolute inset-0 bg-black/50"></div>
    <div class="relative bg-white dark:bg-slate-900 rounded-xl shadow-xl max-w-lg w-full max-h-[85vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between sticky top-0 bg-white dark:bg-slate-900">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Help Center</h3>
            <button id="helpCloseBtn" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition" aria-label="Close help">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="px-6 py-5 space-y-4">
            <div class="rounded-lg bg-slate-50 dark:bg-slate-800 p-4">
                <h4 class="font-medium text-slate-900 dark:text-white text-sm">Getting Started</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Use the sidebar to navigate between Dashboard, Employees, Attendance, Leave, Notifications, Payroll and Reports. Your role determines which sections you can access.</p>
            </div>
            <div class="rounded-lg bg-slate-50 dark:bg-slate-800 p-4">
                <h4 class="font-medium text-slate-900 dark:text-white text-sm">Changing the Theme</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Open Settings and use the Dark Mode toggle. Your preference is saved and applied everywhere you sign in.</p>
            </div>
            <div class="rounded-lg bg-slate-50 dark:bg-slate-800 p-4">
                <h4 class="font-medium text-slate-900 dark:text-white text-sm">Need more help?</h4>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Contact your system administrator for help with permissions, accounts or any module you cannot access.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const themeToggle = document.getElementById('themeToggle');
    const themeInput = document.getElementById('themeInput');
    const themeForm = document.getElementById('themeForm');
    const themeKnob = document.getElementById('themeKnob');
    const themeLabel = document.getElementById('themeLabel');
    const knobIconSun = document.getElementById('knobIconSun');
    const knobIconMoon = document.getElementById('knobIconMoon');
    const trackIconSun = document.getElementById('trackIconSun');
    const trackIconMoon = document.getElementById('trackIconMoon');

    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const isDark = document.documentElement.classList.contains('dark');
            const next = isDark ? 'light' : 'dark';

            if (next === 'dark') {
                document.documentElement.classList.add('dark');
                themeToggle.classList.remove('from-amber-300', 'via-orange-200', 'to-sky-300', 'shadow-amber-400/40');
                themeToggle.classList.add('from-indigo-600', 'via-indigo-500', 'to-purple-600', 'shadow-indigo-950/50');
                themeKnob.classList.remove('translate-x-0');
                themeKnob.classList.add('translate-x-7');
                knobIconSun.classList.add('hidden');
                knobIconMoon.classList.remove('hidden');
                trackIconSun.classList.remove('opacity-100');
                trackIconSun.classList.add('opacity-30');
                trackIconMoon.classList.remove('opacity-30');
                trackIconMoon.classList.add('opacity-100');
                themeLabel.textContent = 'Currently using dark theme';
                themeToggle.setAttribute('aria-checked', 'true');
            } else {
                document.documentElement.classList.remove('dark');
                themeToggle.classList.remove('from-indigo-600', 'via-indigo-500', 'to-purple-600', 'shadow-indigo-950/50');
                themeToggle.classList.add('from-amber-300', 'via-orange-200', 'to-sky-300', 'shadow-amber-400/40');
                themeKnob.classList.remove('translate-x-7');
                themeKnob.classList.add('translate-x-0');
                knobIconSun.classList.remove('hidden');
                knobIconMoon.classList.add('hidden');
                trackIconSun.classList.remove('opacity-30');
                trackIconSun.classList.add('opacity-100');
                trackIconMoon.classList.remove('opacity-100');
                trackIconMoon.classList.add('opacity-30');
                themeLabel.textContent = 'Currently using light theme';
                themeToggle.setAttribute('aria-checked', 'false');
            }

            themeInput.value = next;
            fetch('{{ route('settings.theme') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ theme: next })
            }).then(function(res) {
                if (!res.ok) themeForm.submit();
            }).catch(function() {
                themeForm.submit();
            });
        });
    }

    const helpBtn = document.getElementById('helpBtn');
    const helpModal = document.getElementById('helpModal');
    const helpOverlay = document.getElementById('helpOverlay');
    const helpCloseBtn = document.getElementById('helpCloseBtn');

    function openHelp() {
        helpModal.classList.remove('hidden');
        helpModal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
    }

    function closeHelp() {
        helpModal.classList.add('hidden');
        helpModal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }

    if (helpBtn) helpBtn.addEventListener('click', openHelp);
    if (helpOverlay) helpOverlay.addEventListener('click', closeHelp);
    if (helpCloseBtn) helpCloseBtn.addEventListener('click', closeHelp);

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && helpModal && !helpModal.classList.contains('hidden')) {
            closeHelp();
        }
    });
</script>
@endpush
