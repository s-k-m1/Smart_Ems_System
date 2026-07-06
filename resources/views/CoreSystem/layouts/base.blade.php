<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart EMS</title>
     <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
         <aside class="w-64 bg-slate-900 text-white">
            
         <div class="h-20 flex items-center justify-center border-b border-slate-700">
            <div class="text-center">
                <h1 class="text-2xl font-bold">
                    Smart EMS
                </h1>
                <p class="text-xs text-gray-400">Employee Management</p>
            </div>
         </div>
         <!-- Menu -->
          <nav class="mt-8">
            <a href="#" class="flex items-center gap-3 px-6 py-4 hover:bg-slate-800">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>
            <a href="/employees/create" class="flex items-center gap-3 px-6 py-4 hover:bg-slate-800">
                <i class="fa-solid fa-users"></i>
                Employees
            </a>
            <a href="#" class="flex items-center gap-3 px-6 py-4 hover:bg-slate-800">
                <i class="fa-solid fa-calender-check"></i>
                Attendance
            </a>
            <a href="/payroll" class="flex items-center gap-3 px-6 py-4 bg-emerald-600">
                <i class="fa-solid fa-money-check-dollar"></i>
                Payroll
            </a>
            <a href="#" class="flex items-center gap-3 px-6  py-4 hover:bg-slate-800">
                <i  class="fa-solid fa chart-column"></i>
                Reports
            </a>
          </nav>
         </aside>

         <!-- Main Content -->
          <div class="flex-1">
            <!-- Top Navbar -->
             <header class="bg-white shadow px-8 py-5 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-700">
                        Smart Employee Management System
                    </h2>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right">
                        <p class="font-semibold">
                            Admin
                        </p>
                        <p class="text-sm text-gray-500">
                            HR Department
                        </p>
                    </div>
                    <img src="https://ui-avatars.com/api/?name=Admin" class="w-11 h-11 rounded-full">
                </div>
             </header>
             <!-- Page Content -->
              <main class="p-8">
                @yield('content')
              </main>

          </div>
    </div>
    
</body>
</html>