<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Payroll Dashboard</title>
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- SideBar -->
        <div class="w-64 bg-gray-900 text-white">
            <div class="p-6 text-2xl font-bold border-b border-gray-700">
                Payroll System
            </div>
            <ul class="mt-6">
                <li class="px-6 py-3 bg-emerald-500">Dashboard</li>
                <li class="px-6 py-3 hover:bg-gray-800">Employees</li>
                <li class="px-6 py-3 hover:bg-gray-800">Payroll Reports</li>
                <li class="px-6 py-3 hover:bg-gray-800">Settings</li>
            </ul>
        </div>
        <!-- Main Content -->
        <div class="flex-1 bg-gray-100 min-h-screen overflow-x-hidden">
            <!-- Header -->
            <div class="bg-white shadow-sm border-b">

                <div class="flex justify-between items-center px-10 py-6">

                    <div>

                        <h1 class="text-3xl font-bold text-gray-800">
                            Payroll Dashboard
                        </h1>

                        <p class="text-gray-500 mt-1">
                            Manage employee payrolls efficiently.
                        </p>

                    </div>

                    <a href="/payroll/create"
                        class="bg-emerald-600 hover:bg-emerald-700 transition text-white px-6 py-3 rounded-xl font-semibold shadow-lg">

                        + Generate Payroll

                    </a>

                </div>
            </div>
            <div class="px-10 py-8">
                <!-- Summary Cards -->
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8 mb-10">

                    <!-- Employees -->
                    <div class="bg-gradient-to-br from-pink-500 via-pink-600 to-rose-600 rounded-2xl shadow-xl p-6 text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">

                        <div class="flex justify-center">
                            <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center shadow">
                                <i class="fa-solid fa-users text-pink-600 text-2xl"></i>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <h1 class="text-5xl font-extrabold">{{ $totalEmployees }}</h1>
                            <h2 class="text-xl font-semibold mt-4">Employees</h2>
                        </div>

                    </div>

                    <!-- Payrolls -->
                    <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 rounded-2xl shadow-xl p-6 text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">

                        <div class="flex justify-center">
                            <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center shadow">
                                <i class="fa-solid fa-file-invoice-dollar text-blue-600 text-2xl"></i>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <h1 class="text-5xl font-extrabold">{{ $totalPayrolls }}</h1>
                            <h2 class="text-xl font-semibold mt-4">Payrolls</h2>
                        </div>

                    </div>

                    <!-- Paid Payrolls -->
                    <div class="bg-gradient-to-br from-green-500 via-green-600 to-emerald-700 rounded-2xl shadow-xl p-6 text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">

                        <div class="flex justify-center">
                            <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center shadow">
                                <i class="fa-solid fa-circle-check text-green-600 text-2xl"></i>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <h1 class="text-5xl font-extrabold">{{ $paidPayrolls }}</h1>
                            <h2 class="text-xl font-semibold mt-4">Paid Payrolls</h2>
                        </div>

                    </div>

                    <!-- Pending Payrolls -->
                    <div class="bg-gradient-to-br from-orange-400 via-orange-500 to-amber-600 rounded-2xl shadow-xl p-6 text-white transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">

                        <div class="flex justify-center">
                            <div class="w-14 h-14 bg-white rounded-lg flex items-center justify-center shadow">
                                <i class="fa-solid fa-clock text-orange-500 text-2xl"></i>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <h1 class="text-5xl font-extrabold">{{ $pendingPayrolls }}</h1>
                            <h2 class="text-xl font-semibold mt-4">Pending Payrolls</h2>
                        </div>

                    </div>

                </div>
                <!-- Success Message -->
                @if(session('success'))
                <div class="mb-5 rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-700">
                    {{session('success')}}
                </div>
                @endif
                <!-- Table -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="p-3 text-left">Employee</th>
                                <th class="p-3 text-left">Month</th>
                                <th class="p-3 text-left">Year</th>
                                <th class="p-3 text-left">Present</th>
                                <th class="p-3 text-left">Absent</th>
                                <th class="p-3 text-left">Bonus</th>
                                <th class="p-3 text-left">Deduction</th>
                                <th class="p-3 text-left">Net Salary</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payrolls as $payroll)
                            <tr class="border-b">
                                <td class="p-3">{{$payroll->employee->name}}</td>
                                <td class="p-3">{{$payroll->month}}</td>
                                <td class="p-3">{{$payroll->year}}</td>
                                <td class="p-3 text-center">
                                    {{
                                        \App\Models\Attendance::where('employee_id',$payroll-> employee_id)
                                            ->whereYear('date', $payroll->year)
                                            ->whereMonth('date', date('n', strtotime($payroll->month)))
                                            ->where('status', 'Present')
                                            ->count()
                                     }}
                                </td>
                                <td class="p-3 text-center">
                                    {{
                                        \App\Models\Attendance::where('employee_id',$payroll-> employee_id)
                                            ->whereYear('date', $payroll->year)
                                            ->whereMonth('date', date('n', strtotime($payroll->month)))
                                            ->where('status', 'Absent')
                                            ->count()
                                     }}
                                </td>
                                <td class="p-3 whitespace-nowrap">Rs. {{number_format($payroll->bonus,2)}}</td>
                                <td class="p-3 whitespace-nowrap">Rs. {{number_format($payroll->leave_deduction,2)}}</td>
                                <td class="p-3 whitespace-nowrap">Rs. {{number_format($payroll->net_salary,2)}}</td>
                                <td class="p-3">
                                    @if($payroll->status =='Pending')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        Pending
                                    </span>
                                    @else
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                        Paid
                                    </span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <div class="flex justify-center items-center gap-2">

                                        {{-- Mark Paid --}}
                                        @if($payroll->status == 'Pending')
                                        <form action="{{ route('payroll.paid',$payroll->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="w-10 h-10 bg-green-600 hover:bg-green-700 rounded-lg text-white transition">

                                                <i class="fa-solid fa-check"></i>

                                            </button>
                                        </form>
                                        @endif

                                        {{-- Edit --}}
                                        <a href="{{ route('payroll.edit', $payroll->id)}}"
                                            class="w-10 h-10 bg-blue-600 hover:bg-blue-700 rounded-lg text-white flex items-center justify-center transition">

                                            <i class="fa-solid fa-pen"></i>

                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('payroll.destroy',$payroll->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this payroll?');">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="w-10 h-10 bg-red-600 hover:bg-red-700 rounded-lg text-white transition">

                                                <i class="fa-solid fa-trash"></i>

                                            </button>

                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>

</html>