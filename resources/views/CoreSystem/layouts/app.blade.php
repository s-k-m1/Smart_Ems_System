<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Smart EMS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="bg-slate-50 min-h-screen">
    @include('CoreSystem.layouts.sidebar')

    <div class="ml-64 min-h-screen">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
