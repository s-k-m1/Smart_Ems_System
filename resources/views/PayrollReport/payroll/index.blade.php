
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css'])
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
        <div class="flex-1 p-8">
            <h1 class="text-3xl font-bold mb-6">
                Payroll Dashboard
            </h1>
            <!-- Summary Cards -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <div class="bg-pink-500 text-white p-6 rounded-lg shadow">
                    <h2 class="text-lg">Total Payrolls</h2>
                    <p class="text-3xl font-bold">
                        {{$payrolls->count()}}
                    </p>
                </div>
                <div class="bg-yellow-600 text-white p-6 rounded-lg shadow">
                    <h2 class="text-lg">Total Salary Paid</h2>
                    <p class="text-3xl font-bold">
                        Rs.{{$payrolls->sum('net_salary')}}
                    </p>
                </div>
                <div class="bg-blue-500 text-white p-6 rounded-lg shadow">
                    <h2 class="text-lg">Pending Payrolls</h2>
                    <p class="text-3xl font-bold">
                        {{$payrolls->where('status','Pending')->count()}}
                    </p>
                </div>
            </div>
            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Employee</th>
                            <th class="p-3 text-left">Month</th>
                            <th class="p-3 text-left">Year</th>
                            <th class="p-3 text-left">Bonus</th>
                            <th class="p-3 text-left">Deduction</th>
                            <th class="p-3 text-left">Net Salary</th>
                            <th class="p-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payrolls as $payroll)
                        <tr class="border-b">
                            <td class="p-3">{{$payroll->employee->name}}</td>
                            <td class="p-3">{{$payroll->month}}</td>
                            <td class="p-3">{{$payroll->year}}</td>
                            <td class="p-3">{{$payroll->bonus}}</td>
                            <td class="p-3">{{$payroll->leave_deduction}}</td>
                            <td class="p-3">{{$payroll->net_salary}}</td>
                            <td class="p-3"><span class="bg-yellow-200 text-yellow-800 px-3 py-1 rounded">{{$payroll->status}}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

</html>