@extends('CoreSystem.layouts.app')

@section('title', 'Employee Management')

@section('content')

<header class="bg-white border-b border-slate-200">
    <div class="px-4 sm:px-8 py-4 sm:py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-xl sm:text-2xl font-semibold text-slate-800">Employee Management</h1>
            <p class="text-sm text-slate-500 mt-1">View and manage all employees in your organization</p>
        </div>
        <a href="{{ route('employees.create') }}"
           class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors text-sm font-medium text-center">
            + Add Employee
        </a>
    </div>
</header>

<main class="px-4 sm:px-8 py-4 sm:py-8">

        @if (session('success'))
            <div class="mb-6 px-4 py-3 rounded-lg bg-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($employees as $index => $employee)
                <div
                    class="employee-card bg-white rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 cursor-pointer p-6 border border-slate-100"
                    data-index="{{ $index }}"
                    data-id="{{ $employee->employee_id }}"
                    data-name="{{ $employee->name }}"
                    data-department="{{ $employee->department }}"
                    data-position="{{ $employee->position }}"
                    data-status="{{ $employee->status }}"
                    data-email="{{ $employee->email }}"
                    data-phone="{{ $employee->phone }}"
                    data-joined="{{ $employee->joined->format('F j, Y') }}"
                    data-address="{{ $employee->address }}"
                    data-image="{{ $employee->image }}"
                    data-present="{{ $employee->present_days }}"
                    data-leave="{{ $employee->leave_taken }}"
                    data-salary="{{ $employee->formatted_salary }}"
                    data-projects="{{ $employee->projects }}"
                    data-edit-url="{{ route('employees.edit', $employee->id) }}"
                    data-delete-url="{{ route('employees.destroy', $employee->id) }}"
                >
                    <div class="flex items-center gap-4">
                        <img src="{{ $employee->image }}" alt="{{ $employee->name }}"
                             class="w-16 h-16 rounded-full object-cover border border-slate-200">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-slate-800 truncate">{{ $employee->name }}</h3>
                            <p class="text-sm text-slate-500">{{ $employee->employee_id }}</p>
                        </div>
                    </div>

                    <div class="mt-4 space-y-1">
                        <p class="text-sm text-slate-600">
                            <span class="font-medium text-slate-700">Department:</span> {{ $employee->department }}
                        </p>
                        <p class="text-sm text-slate-600">
                            <span class="font-medium text-slate-700">Position:</span> {{ $employee->position }}
                        </p>
                    </div>

                    <div class="mt-4">
                        @if ($employee->status === 'Active')
                            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>
                        @else
                            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">Inactive</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <div id="modalOverlay" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50 opacity-0 transition-opacity duration-200">
        <div id="modalBox" class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto scale-95 transition-transform duration-200">

            <div class="flex justify-end p-4 pb-0">
                <button id="closeModalBtn" class="text-slate-400 hover:text-slate-600 text-2xl leading-none transition-colors" aria-label="Close modal">&times;</button>
            </div>

            <div class="flex flex-col items-center px-6 pb-6 text-center">
                <img id="modalImage" src="" alt="Employee photo" class="w-24 h-24 rounded-full object-cover border-2 border-slate-200 mb-3">
                <h2 id="modalName" class="text-xl font-semibold text-slate-800"></h2>
                <p id="modalPosition" class="text-sm text-slate-500"></p>
                <p id="modalDepartment" class="text-sm text-slate-500"></p>
                <span id="modalStatus" class="inline-block mt-2 px-3 py-1 text-xs font-medium rounded-full"></span>
            </div>

            <div class="px-6 pb-6">
                <h3 class="text-sm font-semibold text-slate-700 mb-3 uppercase tracking-wide">Employee Information</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div><p class="text-slate-400">Employee ID</p><p id="modalId" class="text-slate-700 font-medium"></p></div>
                    <div><p class="text-slate-400">Email</p><p id="modalEmail" class="text-slate-700 font-medium break-all"></p></div>
                    <div><p class="text-slate-400">Phone Number</p><p id="modalPhone" class="text-slate-700 font-medium"></p></div>
                    <div><p class="text-slate-400">Department</p><p id="modalDepartmentInfo" class="text-slate-700 font-medium"></p></div>
                    <div><p class="text-slate-400">Position</p><p id="modalPositionInfo" class="text-slate-700 font-medium"></p></div>
                    <div><p class="text-slate-400">Date Joined</p><p id="modalJoined" class="text-slate-700 font-medium"></p></div>
                    <div class="sm:col-span-2"><p class="text-slate-400">Address</p><p id="modalAddress" class="text-slate-700 font-medium"></p></div>
                </div>
            </div>

            <div class="px-6 pb-6">
                <h3 class="text-sm font-semibold text-slate-700 mb-3 uppercase tracking-wide">Quick Statistics</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-slate-50 rounded-lg p-3 text-center"><p id="modalPresent" class="text-lg font-semibold text-slate-800"></p><p class="text-xs text-slate-500 mt-1">Present Days</p></div>
                    <div class="bg-slate-50 rounded-lg p-3 text-center"><p id="modalLeave" class="text-lg font-semibold text-slate-800"></p><p class="text-xs text-slate-500 mt-1">Leave Taken</p></div>
                    <div class="bg-slate-50 rounded-lg p-3 text-center"><p id="modalSalary" class="text-lg font-semibold text-slate-800"></p><p class="text-xs text-slate-500 mt-1">Salary</p></div>
                    <div class="bg-slate-50 rounded-lg p-3 text-center"><p id="modalProjects" class="text-lg font-semibold text-slate-800"></p><p class="text-xs text-slate-500 mt-1">Projects</p></div>
                </div>
            </div>

            <!-- Edit / Delete actions -->
            <div class="flex flex-col sm:flex-row gap-3 px-6 pb-6">
                <button id="closeModalBtnBottom" class="flex-1 px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition-colors text-sm font-medium">
                    Close
                </button>
                <a id="modalEditBtn" href="#"
                   class="flex-1 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors text-sm font-medium text-center">
                    Edit
                </a>
                <form id="modalDeleteForm" action="#" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Are you sure you want to delete this employee?')"
                            class="w-full px-4 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors text-sm font-medium">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const employeeCards = document.querySelectorAll('.employee-card');
        const modalOverlay = document.getElementById('modalOverlay');
        const modalBox = document.getElementById('modalBox');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeModalBtnBottom = document.getElementById('closeModalBtnBottom');

        function openModal(card) {
            const status = card.dataset.status;

            document.getElementById('modalImage').src = card.dataset.image;
            document.getElementById('modalImage').alt = card.dataset.name;
            document.getElementById('modalName').textContent = card.dataset.name;
            document.getElementById('modalPosition').textContent = card.dataset.position;
            document.getElementById('modalDepartment').textContent = card.dataset.department;

            const statusBadge = document.getElementById('modalStatus');
            statusBadge.textContent = status;
            statusBadge.className = status === 'Active'
                ? 'inline-block mt-2 px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700'
                : 'inline-block mt-2 px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700';

            document.getElementById('modalId').textContent = card.dataset.id;
            document.getElementById('modalEmail').textContent = card.dataset.email;
            document.getElementById('modalPhone').textContent = card.dataset.phone;
            document.getElementById('modalDepartmentInfo').textContent = card.dataset.department;
            document.getElementById('modalPositionInfo').textContent = card.dataset.position;
            document.getElementById('modalJoined').textContent = card.dataset.joined;
            document.getElementById('modalAddress').textContent = card.dataset.address;

            document.getElementById('modalPresent').textContent = card.dataset.present;
            document.getElementById('modalLeave').textContent = card.dataset.leave;
            document.getElementById('modalSalary').textContent = card.dataset.salary;
            document.getElementById('modalProjects').textContent = card.dataset.projects;

            // Point the Edit link and Delete form at this specific employee's routes.
            document.getElementById('modalEditBtn').href = card.dataset.editUrl;
            document.getElementById('modalDeleteForm').action = card.dataset.deleteUrl;

            modalOverlay.classList.remove('hidden');
            setTimeout(() => {
                modalOverlay.classList.remove('opacity-0');
                modalBox.classList.remove('scale-95');
                modalBox.classList.add('scale-100');
            }, 10);

            document.body.classList.add('overflow-hidden');
        }

        function closeModal() {
            modalOverlay.classList.add('opacity-0');
            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-95');
            setTimeout(() => modalOverlay.classList.add('hidden'), 200);
            document.body.classList.remove('overflow-hidden');
        }

        employeeCards.forEach((card) => card.addEventListener('click', () => openModal(card)));
        closeModalBtn.addEventListener('click', closeModal);
        closeModalBtnBottom.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) closeModal(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) closeModal(); });
    </script>

@endsection