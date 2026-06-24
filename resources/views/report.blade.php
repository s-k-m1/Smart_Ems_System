<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Smart EMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- ============ SIDEBAR (placeholder — replace with shared layout) ============ -->
    <div class="flex">

        <aside class="w-48 bg-gray-800 text-white p-4">
            <h1 class="font-bold text-lg mb-4">Smart EMS</h1>
            <a href="#" class="block py-2">Dashboard</a>
            <a href="#" class="block py-2">Employees</a>
            <a href="#" class="block py-2">Attendance</a>
            <a href="#" class="block py-2 bg-blue-600 px-2 rounded">Reports</a>
            <a href="#" class="block py-2">Settings</a>
        </aside>

        <!-- ============ MAIN CONTENT ============ -->
        <main class="flex-1 p-6">

            <h1 class="text-2xl font-bold mb-1">Reports</h1>
            <p class="text-gray-500 mb-4">Attendance, payroll, and employee distribution overview</p>

            <!-- Tab buttons. data-tab tells our JS which panel to show. -->
            <div class="flex gap-2 mb-4">
                <button class="tab-btn bg-blue-600 text-white px-4 py-2 rounded" data-tab="attendance">Attendance</button>
                <button class="tab-btn bg-gray-200 px-4 py-2 rounded" data-tab="payroll">Payroll</button>
                <button class="tab-btn bg-gray-200 px-4 py-2 rounded" data-tab="distribution">Distribution</button>
            </div>

            <!-- ====================================================== -->
            <!-- TAB 1: ATTENDANCE & LEAVE                               -->
            <!-- ====================================================== -->
            <section id="panel-attendance" class="tab-panel">

                <!-- Summary numbers -->
                <div class="grid grid-cols-4 gap-4 mb-4">
                    <div class="bg-white p-4 rounded">
                        <p class="text-gray-500 text-sm">Total</p>
                        <p class="text-xl font-bold" id="attTotal">{{ $attendanceSummary['total'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded">
                        <p class="text-gray-500 text-sm">Present</p>
                        <p class="text-xl font-bold text-green-600" id="attPresent">{{ $attendanceSummary['present'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded">
                        <p class="text-gray-500 text-sm">Absent</p>
                        <p class="text-xl font-bold text-red-600" id="attAbsent">{{ $attendanceSummary['absent'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded">
                        <p class="text-gray-500 text-sm">Leave</p>
                        <p class="text-xl font-bold text-yellow-600" id="attLeave">{{ $attendanceSummary['leave'] }}</p>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white p-4 rounded mb-4 flex flex-wrap gap-4">
                    <div>
                        <label class="block text-sm text-gray-500">From</label>
                        <input type="date" id="attFromDate" class="border p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500">To</label>
                        <input type="date" id="attToDate" class="border p-2 rounded">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500">Employee</label>
                        <select id="attEmployeeFilter" class="border p-2 rounded">
                            <option value="">All Employees</option>
                            @foreach ($attendanceEmployees as $employee)
                                <option value="{{ $employee }}">{{ $employee }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500">Status</label>
                        <select id="attStatusFilter" class="border p-2 rounded">
                            <option value="">All</option>
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                            <option value="Leave">Leave</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500">Search</label>
                        <input type="text" id="attSearchBox" placeholder="Search by name..." class="border p-2 rounded">
                    </div>
                    <button id="attResetBtn" class="bg-gray-200 px-4 py-2 rounded self-end">Reset</button>
                </div>

                <!-- Table -->
                <table class="w-full bg-white rounded">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="p-3">Name</th>
                            <th class="p-3">Date</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody id="attTableBody"></tbody>
                </table>
                <!-- This message only shows when there are no rows to display. JS controls it with the "hidden" class. -->
                <p id="attEmptyState" class="text-center text-gray-500 p-4 hidden">No records match the selected filters.</p>
            </section>

            <!-- ====================================================== -->
            <!-- TAB 2: PAYROLL / SALARY                                 -->
            <!-- ====================================================== -->
            <section id="panel-payroll" class="tab-panel hidden">

                <div class="grid grid-cols-4 gap-4 mb-4">
                    <div class="bg-white p-4 rounded">
                        <p class="text-gray-500 text-sm">Total Employees</p>
                        <p class="text-xl font-bold" id="payTotal">{{ $payrollSummary['total_employees'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded">
                        <p class="text-gray-500 text-sm">Total Payroll</p>
                        <p class="text-xl font-bold" id="payTotalAmount">Rs. {{ number_format($payrollSummary['total_payroll']) }}</p>
                    </div>
                    <div class="bg-white p-4 rounded">
                        <p class="text-gray-500 text-sm">Paid</p>
                        <p class="text-xl font-bold text-green-600" id="payPaid">{{ $payrollSummary['paid'] }}</p>
                    </div>
                    <div class="bg-white p-4 rounded">
                        <p class="text-gray-500 text-sm">Pending</p>
                        <p class="text-xl font-bold text-yellow-600" id="payPending">{{ $payrollSummary['pending'] }}</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded mb-4 flex flex-wrap gap-4">
                    <div>
                        <label class="block text-sm text-gray-500">Status</label>
                        <select id="payStatusFilter" class="border p-2 rounded">
                            <option value="">All</option>
                            <option value="Paid">Paid</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500">Search</label>
                        <input type="text" id="paySearchBox" placeholder="Search by name..." class="border p-2 rounded">
                    </div>
                    <button id="payResetBtn" class="bg-gray-200 px-4 py-2 rounded self-end">Reset</button>
                </div>

                <table class="w-full bg-white rounded">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="p-3">Name</th>
                            <th class="p-3">Salary (Rs.)</th>
                            <th class="p-3">Status</th>
                        </tr>
                    </thead>
                    <tbody id="payTableBody"></tbody>
                </table>
                <p id="payEmptyState" class="text-center text-gray-500 p-4 hidden">No records match the selected filters.</p>
            </section>

            <!-- ====================================================== -->
            <!-- TAB 3: EMPLOYEE DISTRIBUTION                            -->
            <!-- ====================================================== -->
            <section id="panel-distribution" class="tab-panel hidden">

                <!-- Department count cards. JS fills this in based on the filtered rows. -->
                <div id="deptGrid" class="grid grid-cols-3 gap-4 mb-4"></div>

                <div class="bg-white p-4 rounded mb-4 flex flex-wrap gap-4">
                    <div>
                        <label class="block text-sm text-gray-500">Department</label>
                        <select id="distDeptFilter" class="border p-2 rounded">
                            <option value="">All Departments</option>
                            @foreach ($departments as $dept)
                                <option value="{{ $dept }}">{{ $dept }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-500">Search</label>
                        <input type="text" id="distSearchBox" placeholder="Search by name..." class="border p-2 rounded">
                    </div>
                    <button id="distResetBtn" class="bg-gray-200 px-4 py-2 rounded self-end">Reset</button>
                </div>

                <table class="w-full bg-white rounded">
                    <thead>
                        <tr class="bg-gray-50 text-left">
                            <th class="p-3">Name</th>
                            <th class="p-3">Department</th>
                            <th class="p-3">Designation</th>
                        </tr>
                    </thead>
                    <tbody id="distTableBody"></tbody>
                </table>
                <p id="distEmptyState" class="text-center text-gray-500 p-4 hidden">No records match the selected filters.</p>
            </section>

        </main>
    </div>

<script>

// turns php into js use

    const attendanceData   = @json($attendanceData);
    const payrollData      = @json($payrollData);
    const distributionData = @json($distributionData);


// we are usung threee buttons in same page making three pages like feeling and it helps feel like seprate page hiding unwanted pannel reset every button is non active and blue if active

    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanels  = document.querySelectorAll('.tab-panel');

    tabButtons.forEach(function (button) {
        button.addEventListener('click', function () {

            // hide all panels first
            tabPanels.forEach(function (panel) {
                panel.classList.add('hidden');
            });

            // show only the panel whose id matches this button's data-tab
            const panelId = 'panel-' + button.dataset.tab;
            document.getElementById(panelId).classList.remove('hidden');

            // reset every button back to the gray "inactive" style
            tabButtons.forEach(function (btn) {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-gray-200');
            });

            // make the clicked button blue ("active")
            button.classList.remove('bg-gray-200');
            button.classList.add('bg-blue-600', 'text-white');
        });
    });
             // attendence
    function renderAttendance(rows) {
        const tableBody = document.getElementById('attTableBody');
        tableBody.innerHTML = ''; // clear old rows before drawing new ones

        // if there are no rows, show the "no records" message and stop here
        if (rows.length === 0) {
            document.getElementById('attEmptyState').classList.remove('hidden');
        } else {
            document.getElementById('attEmptyState').classList.add('hidden');
        }

        // build one <tr> per row of data
        rows.forEach(function (row) {
            const tr = document.createElement('tr');
            tr.innerHTML =
                '<td class="p-3 border-t">' + row.name + '</td>' +
                '<td class="p-3 border-t">' + row.date + '</td>' +
                '<td class="p-3 border-t">' + row.status + '</td>';
            tableBody.appendChild(tr);
        });

        // update the 4 summary cards based on what is currently shown
        document.getElementById('attTotal').textContent   = rows.length;
        document.getElementById('attPresent').textContent = rows.filter(r => r.status === 'Present').length;
        document.getElementById('attAbsent').textContent  = rows.filter(r => r.status === 'Absent').length;
        document.getElementById('attLeave').textContent   = rows.filter(r => r.status === 'Leave').length;
    }

    function filterAttendance() {
        const fromDate = document.getElementById('attFromDate').value;
        const toDate   = document.getElementById('attToDate').value;
        const employee = document.getElementById('attEmployeeFilter').value;
        const status   = document.getElementById('attStatusFilter').value;
        const search   = document.getElementById('attSearchBox').value.toLowerCase();

        // .filter() keeps only the rows where the function returns true
        const filteredRows = attendanceData.filter(function (row) {
            if (fromDate && row.date < fromDate) return false;
            if (toDate && row.date > toDate) return false;
            if (employee && row.name !== employee) return false;
            if (status && row.status !== status) return false;
            if (search && !row.name.toLowerCase().includes(search)) return false;
            return true; // row passed every check, so keep it
        });

        renderAttendance(filteredRows);
    }

    // run filterAttendance() every time any filter changes
    document.getElementById('attFromDate').addEventListener('change', filterAttendance);
    document.getElementById('attToDate').addEventListener('change', filterAttendance);
    document.getElementById('attEmployeeFilter').addEventListener('change', filterAttendance);
    document.getElementById('attStatusFilter').addEventListener('change', filterAttendance);
    document.getElementById('attSearchBox').addEventListener('input', filterAttendance);

    // reset button clears every filter and shows all rows again
    document.getElementById('attResetBtn').addEventListener('click', function () {
        document.getElementById('attFromDate').value = '';
        document.getElementById('attToDate').value = '';
        document.getElementById('attEmployeeFilter').value = '';
        document.getElementById('attStatusFilter').value = '';
        document.getElementById('attSearchBox').value = '';
        renderAttendance(attendanceData);
    });

    //      payroll
    function renderPayroll(rows) {
        const tableBody = document.getElementById('payTableBody');
        tableBody.innerHTML = '';

        if (rows.length === 0) {
            document.getElementById('payEmptyState').classList.remove('hidden');
        } else {
            document.getElementById('payEmptyState').classList.add('hidden');
        }

        rows.forEach(function (row) {
            const tr = document.createElement('tr');
            tr.innerHTML =
                '<td class="p-3 border-t">' + row.name + '</td>' +
                '<td class="p-3 border-t">Rs. ' + row.salary.toLocaleString() + '</td>' +
                '<td class="p-3 border-t">' + row.status + '</td>';
            tableBody.appendChild(tr);
        });

        // add up the salary column to get a total for the filtered rows
        let totalAmount = 0;
        rows.forEach(function (row) {
            totalAmount = totalAmount + row.salary;
        });

        document.getElementById('payTotal').textContent       = rows.length;
        document.getElementById('payTotalAmount').textContent = 'Rs. ' + totalAmount.toLocaleString();
        document.getElementById('payPaid').textContent        = rows.filter(r => r.status === 'Paid').length;
        document.getElementById('payPending').textContent     = rows.filter(r => r.status === 'Pending').length;
    }

    function filterPayroll() {
        const status = document.getElementById('payStatusFilter').value;
        const search = document.getElementById('paySearchBox').value.toLowerCase();

        const filteredRows = payrollData.filter(function (row) {
            if (status && row.status !== status) return false;
            if (search && !row.name.toLowerCase().includes(search)) return false;
            return true;
        });

        renderPayroll(filteredRows);
    }

    document.getElementById('payStatusFilter').addEventListener('change', filterPayroll);
    document.getElementById('paySearchBox').addEventListener('input', filterPayroll);

    document.getElementById('payResetBtn').addEventListener('click', function () {
        document.getElementById('payStatusFilter').value = '';
        document.getElementById('paySearchBox').value = '';
        renderPayroll(payrollData);
    });
// employee distribution
    // This tab is a little different: on top of a table, it also
    // shows a small card per department with a count of how many
    // employees are in it. renderDeptCards() builds those cards.

    function renderDeptCards(rows) {
        // count how many employees are in each department.
        // counts will look like: { "IT": 3, "HR": 2 }
        const counts = {};
        rows.forEach(function (row) {
            if (counts[row.department]) {
                counts[row.department] = counts[row.department] + 1;
            } else {
                counts[row.department] = 1;
            }
        });

        const deptGrid = document.getElementById('deptGrid');
        deptGrid.innerHTML = '';

        // Object.keys(counts) gives us a list of department names
        Object.keys(counts).forEach(function (deptName) {
            const card = document.createElement('div');
            card.className = 'bg-white p-4 rounded';
            card.innerHTML =
                '<p class="font-bold">' + deptName + '</p>' +
                '<p class="text-gray-500 text-sm">' + counts[deptName] + ' employees</p>';
            deptGrid.appendChild(card);
        });
    }

    function renderDistribution(rows) {
        const tableBody = document.getElementById('distTableBody');
        tableBody.innerHTML = '';

        if (rows.length === 0) {
            document.getElementById('distEmptyState').classList.remove('hidden');
        } else {
            document.getElementById('distEmptyState').classList.add('hidden');
        }

        rows.forEach(function (row) {
            const tr = document.createElement('tr');
            tr.innerHTML =
                '<td class="p-3 border-t">' + row.name + '</td>' +
                '<td class="p-3 border-t">' + row.department + '</td>' +
                '<td class="p-3 border-t">' + row.designation + '</td>';
            tableBody.appendChild(tr);
        });

        renderDeptCards(rows);
    }

    function filterDistribution() {
        const department = document.getElementById('distDeptFilter').value;
        const search      = document.getElementById('distSearchBox').value.toLowerCase();

        const filteredRows = distributionData.filter(function (row) {
            if (department && row.department !== department) return false;
            if (search && !row.name.toLowerCase().includes(search)) return false;
            return true;
        });

        renderDistribution(filteredRows);
    }

    document.getElementById('distDeptFilter').addEventListener('change', filterDistribution);
    document.getElementById('distSearchBox').addEventListener('input', filterDistribution);

    document.getElementById('distResetBtn').addEventListener('click', function () {
        document.getElementById('distDeptFilter').value = '';
        document.getElementById('distSearchBox').value = '';
        renderDistribution(distributionData);
    });


// first view
    // When the page first loads, show everything with no filters applied, so the tables aren't empty.

    renderAttendance(attendanceData);
    renderPayroll(payrollData);
    renderDistribution(distributionData);

</script>

</body>
</html>