<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Forgot Password - Smart EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-slate-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8">
            <div class="text-center mb-6 sm:mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">Forgot Password</h1>
                <p class="text-slate-500 mt-2 text-sm sm:text-base">Enter your email and we'll send you a reset link</p>
            </div>

            @if (session('status'))
                <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-600 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-50 text-red-600 text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none text-sm sm:text-base">
                </div>

                <button type="submit"
                        class="w-full py-3 rounded-xl bg-blue-600 text-white font-semibold hover:bg-blue-700 transition text-sm sm:text-base">
                    Send Password Reset Link
                </button>
            </form>

            <p class="text-center mt-6 text-sm text-slate-500">
                Remember your password?
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Back to Login</a>
            </p>
        </div>
    </div>
<script>
setTimeout(function(){
    var el = document.querySelector('.bg-green-50, .bg-red-50');
    if (el) el.style.display = 'none';
}, 3000);
</script>
</body>
</html>
