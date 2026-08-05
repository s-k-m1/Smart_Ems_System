@extends('CoreSystem.layouts.app')

@section('title', 'Employee Management')

@section('content')

@if($isEmployee)
    <header class="bg-white border-b border-slate-200">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div>
                <h1 class="text-lg sm:text-xl font-semibold text-slate-800">My Profile</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Your employee details and information</p>
            </div>
        </div>
    </header>
    <main class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:pl-10">
        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if($employees->isNotEmpty())
            @foreach($employees as $employee)
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-6">
                    <img src="{{ $employee->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($employee->name) . '&background=e8f1ff&color=1e40af&size=64' }}" alt="{{ $employee->name }}"
                         class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-2 border-slate-200 shrink-0">
                    <div class="min-w-0">
                        <h2 class="text-lg sm:text-xl font-semibold text-slate-800 truncate">{{ $employee->name }}</h2>
                        <p class="text-sm text-slate-500">{{ $employee->employee_id }}</p>
                        <span class="inline-block mt-1 px-2.5 py-0.5 text-xs font-medium rounded-full
                            @if($employee->status === 'Active') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $employee->status }}
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div class="bg-slate-50 rounded-lg p-3"><p class="text-xs text-slate-400">Department</p><p class="text-slate-700 font-medium text-sm">{{ $employee->department }}</p></div>
                    <div class="bg-slate-50 rounded-lg p-3"><p class="text-xs text-slate-400">Position</p><p class="text-slate-700 font-medium text-sm">{{ $employee->position }}</p></div>
                    <div class="bg-slate-50 rounded-lg p-3"><p class="text-xs text-slate-400">Email</p><p class="text-slate-700 font-medium text-sm break-all">{{ $employee->email }}</p></div>
                    <div class="bg-slate-50 rounded-lg p-3"><p class="text-xs text-slate-400">Phone</p><p class="text-slate-700 font-medium text-sm">{{ $employee->phone }}</p></div>
                    <div class="bg-slate-50 rounded-lg p-3"><p class="text-xs text-slate-400">Date Joined</p><p class="text-slate-700 font-medium text-sm">{{ $employee->joined->format('F j, Y') }}</p></div>
                    <div class="bg-slate-50 rounded-lg p-3"><p class="text-xs text-slate-400">Address</p><p class="text-slate-700 font-medium text-sm break-words">{{ $employee->address }}</p></div>
                </div>
                <div class="mt-6 grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3">
                    <div class="bg-slate-50 rounded-lg p-3 text-center"><p class="text-base sm:text-lg font-semibold text-slate-800">{{ $employee->present_days }}</p><p class="text-[10px] sm:text-xs text-slate-500 mt-1">Present Days</p></div>
                    <div class="bg-slate-50 rounded-lg p-3 text-center"><p class="text-base sm:text-lg font-semibold text-slate-800">{{ $employee->leave_taken }}</p><p class="text-[10px] sm:text-xs text-slate-500 mt-1">Leave Taken</p></div>
                    <div class="bg-slate-50 rounded-lg p-3 text-center"><p class="text-base sm:text-lg font-semibold text-slate-800">{{ $employee->formatted_salary }}</p><p class="text-[10px] sm:text-xs text-slate-500 mt-1">Salary</p></div>
                    <div class="bg-slate-50 rounded-lg p-3 text-center"><p class="text-base sm:text-lg font-semibold text-slate-800">{{ $employee->projects }}</p><p class="text-[10px] sm:text-xs text-slate-500 mt-1">Projects</p></div>
                </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 text-center">
                <p class="text-slate-500">Employee profile not found.</p>
            </div>
        @endif
    </main>
@else
    <header class="bg-white border-b border-slate-200">
        <div class="px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h1 class="text-lg sm:text-xl font-semibold text-slate-800">Employee Management</h1>
                    <p class="text-xs sm:text-sm text-slate-500 mt-0.5">View and manage all employees in your organization</p>
                </div>
                <a href="{{ route('employees.create') }}"
                   class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors text-sm font-medium text-center shrink-0">
                    + Add Employee
                </a>
            </div>
        </div>
    </header>

    <main class="px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:pl-10">

        @if (session('success'))
            <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach ($employees as $index => $employee)
                <div
                    class="employee-card bg-white rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 cursor-pointer p-4 sm:p-5 border border-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    tabindex="0"
                    role="button"
                    aria-label="View details for {{ $employee->name }}"
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
                    <div class="flex items-center gap-3">
                        <img src="{{ $employee->image ?? 'https://ui-avatars.com/api/?name=' . urlencode($employee->name) . '&background=e8f1ff&color=1e40af&size=64' }}" alt="{{ $employee->name }}"
                             class="w-12 h-12 sm:w-14 sm:h-14 rounded-full object-cover border border-slate-200 shrink-0">
                        <div class="min-w-0 flex-1">
                            <h3 class="font-semibold text-slate-800 truncate text-sm">{{ $employee->name }}</h3>
                            <p class="text-xs text-slate-500">{{ $employee->employee_id }}</p>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <p class="text-xs sm:text-sm text-slate-600 truncate">
                            <span class="font-medium text-slate-700">{{ $employee->department }}</span> · {{ $employee->position }}
                        </p>
                    </div>

<div class="mt-3">
                         @if ($employee->status === 'Active')
                             <span class="inline-block px-2 py-0.5 text-[10px] sm:text-xs font-medium rounded-full bg-green-100 text-green-700">Active</span>
                         @else
                             <span class="inline-block px-2 py-0.5 text-[10px] sm:text-xs font-medium rounded-full bg-red-100 text-red-700">Inactive</span>
                         @endif
                     </div>
                     <div class="mt-2">
                         <a href="{{ route('employees.edit', $employee->id) }}" class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                             Edit
                         </a>
                     </div>
                 </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $employees->links() }}
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

            document.getElementById('modalImage').src = card.dataset.image || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(card.dataset.name) + '&background=e8f1ff&color=1e40af&size=180';
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

        employeeCards.forEach((card) => {
            card.addEventListener('click', () => openModal(card));
            card.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openModal(card);
                }
            });
        });
        closeModalBtn.addEventListener('click', closeModal);
        closeModalBtnBottom.addEventListener('click', closeModal);
        modalOverlay.addEventListener('click', (e) => { if (e.target === modalOverlay) closeModal(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && !modalOverlay.classList.contains('hidden')) closeModal(); });
     </script>
    @endif
@endsection