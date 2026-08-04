<div class="bg-white rounded-[32px] p-8 shadow-lg border border-slate-100 h-full">

    {{-- Header --}}
    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-6">

        <div>
            <h1 class="text-[28px] lg:text-[34px] font-semibold text-slate-700">
                Attendance Rate
            </h1>

            <div class="mt-3 inline-block px-5 py-2 rounded-full bg-blue-50 text-blue-500 text-sm">
                This Year ({{ now()->year }})
            </div>
        </div>

        <h1 id="attRateBig" class="text-[48px] lg:text-[60px] xl:text-[72px] font-bold text-slate-700 leading-none">
            {{ $rate }}%
        </h1>

    </div>

    <hr class="my-8">

    <p class="text-gray-500 font-medium mb-8">
        Monthly Rate ({{ $employee->name }})
    </p>

    {{-- Dynamic Chart --}}
    <div class="relative h-[280px]">
        <canvas id="attendanceRateChart"></canvas>
    </div>

    {{-- Footer --}}
    <div class="mt-8 text-gray-400 leading-7">
        Employee monthly attendance rate highlights consistent attendance performance. Chart updates live as records change.
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var ctx = document.getElementById('attendanceRateChart');
    if (!ctx) return;

    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Present',
                    data: [],
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: 'rgb(37, 99, 235)',
                    borderWidth: 1
                },
                {
                    label: 'Late',
                    data: [],
                    backgroundColor: 'rgba(245, 158, 11, 0.8)',
                    borderColor: 'rgb(217, 119, 6)',
                    borderWidth: 1
                },
                {
                    label: 'Undertime',
                    data: [],
                    backgroundColor: 'rgba(249, 115, 22, 0.8)',
                    borderColor: 'rgb(234, 88, 12)',
                    borderWidth: 1
                },
                {
                    label: 'Absent',
                    data: [],
                    backgroundColor: 'rgba(239, 68, 68, 0.8)',
                    borderColor: 'rgb(220, 38, 38)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { stacked: true, grid: { display: false } },
                y: { stacked: true, beginAtZero: true, ticks: { precision: 0 } }
            },
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 14 } }
            }
        }
    });

    function fetchAttendanceChart() {
        var selector = document.getElementById('employeeSelect');
        var employeeId = selector ? selector.value : '';
        var url = '/attendance/chart-data' + (employeeId ? '?employee=' + employeeId : '');

        fetch(url)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                chart.data.labels = data.labels;
                chart.data.datasets[0].data = data.present;
                chart.data.datasets[1].data = data.late;
                chart.data.datasets[2].data = data.undertime;
                chart.data.datasets[3].data = data.absent;
                chart.update('none');

                var big = document.getElementById('attRateBig');
                if (big && data.yearRate !== null && data.yearRate !== undefined) {
                    big.textContent = data.yearRate + '%';
                }
            })
            .catch(function (err) { console.warn('Attendance chart fetch error:', err); });
    }

    fetchAttendanceChart();

    // Live updates when the page becomes visible again (after saving attendance elsewhere)
    document.addEventListener('visibilitychange', function () {
        if (!document.hidden) fetchAttendanceChart();
    });
    window.addEventListener('focus', fetchAttendanceChart);
    window.addEventListener('storage', function (e) {
        if (e.key === 'attendance_updated') fetchAttendanceChart();
    });
});
</script>