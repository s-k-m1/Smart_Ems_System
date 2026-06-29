<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">

    <header class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <h1 class="text-2xl font-semibold text-slate-800">Employee Management</h1>
            <p class="text-sm text-slate-500 mt-1">View and manage all employees in your organization</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($employees as $index => $employee)
                <!--
                    Each card stores its employee data in data-* attributes.
                    When clicked, JS reads these attributes and fills the modal.
                -->
                <div
                    class="employee-card bg-white rounded-xl shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-200 cursor-pointer p-6 border border-slate-100"
                    data-index="{{ $index }}"
                    data-id="{{ $employee['id'] }}"
                    data-name="{{ $employee['name'] }}"
                    data-department="{{ $employee['department'] }}"
                    data-position="{{ $employee['position'] }}"
                    data-status="{{ $employee['status'] }}"
                    data-email="{{ $employee['email'] }}"
                    data-phone="{{ $employee['phone'] }}"
                    data-joined="{{ $employee['joined'] }}"
                    data-address="{{ $employee['address'] }}"
                    data-image="{{ $employee['image'] }}"
                    data-present="{{ $employee['stats']['present_days'] }}"
                    data-leave="{{ $employee['stats']['leave_taken'] }}"
                    data-salary="{{ $employee['stats']['salary'] }}"
                    data-projects="{{ $employee['stats']['projects'] }}"
                >
                    <div class="flex items-center gap-4">
                        <img
                            src="{{ $employee['image'] }}"
                            alt="{{ $employee['name'] }}"
                            class="w-16 h-16 rounded-full object-cover border border-slate-200"
                        >
                        <div class="flex-1 min-w-0">
                            <h3 class="font-semibold text-slate-800 truncate">{{ $employee['name'] }}</h3>
                            <p class="text-sm text-slate-500">{{ $employee['id'] }}</p>
                        </div>
                    </div>

                    <div class="mt-4 space-y-1">
                        <p class="text-sm text-slate-600">
                            <span class="font-medium text-slate-700">Department:</span> {{ $employee['department'] }}
                        </p>
                        <p class="text-sm text-slate-600">
                            <span class="font-medium text-slate-700">Position:</span> {{ $employee['position'] }}
                        </p>
                    </div>

                    <div class="mt-4">
                        @if ($employee['status'] === 'Active')
                            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                Active
                            </span>
                        @else
                            <span class="inline-block px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    <div
        id="modalOverlay"
        class="hidden fixed inset-0 bg-black/50 flex items-center justify-center p-4 z-50 opacity-0 transition-opacity duration-200"
    >
        <div
            id="modalBox"
            class="bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto scale-95 transition-transform duration-200"
        >
            <!-- Close (X) button -->
            <div class="flex justify-end p-4 pb-0">
                <button
                    id="closeModalBtn"
                    class="text-slate-400 hover:text-slate-600 text-2xl leading-none transition-colors"
                    aria-label="Close modal"
                >
                    &times;
                </button>
            </div>

            <!-- Top section: photo, name, position, department, status -->
            <div class="flex flex-col items-center px-6 pb-6 text-center">
                <img
                    id="modalImage"
                    src=""
                    alt="Employee photo"
                    class="w-24 h-24 rounded-full object-cover border-2 border-slate-200 mb-3"
                >
                <h2 id="modalName" class="text-xl font-semibold text-slate-800"></h2>
                <p id="modalPosition" class="text-sm text-slate-500"></p>
                <p id="modalDepartment" class="text-sm text-slate-500"></p>
                <span
                    id="modalStatus"
                    class="inline-block mt-2 px-3 py-1 text-xs font-medium rounded-full"
                ></span>
            </div>

            <!-- Information section -->
            <div class="px-6 pb-6">
                <h3 class="text-sm font-semibold text-slate-700 mb-3 uppercase tracking-wide">
                    Employee Information
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-slate-400">Employee ID</p>
                        <p id="modalId" class="text-slate-700 font-medium"></p>
                    </div>
                    <div>
                        <p class="text-slate-400">Email</p>
                        <p id="modalEmail" class="text-slate-700 font-medium break-all"></p>
                    </div>
                    <div>
                        <p class="text-slate-400">Phone Number</p>
                        <p id="modalPhone" class="text-slate-700 font-medium"></p>
                    </div>
                    <div>
                        <p class="text-slate-400">Department</p>
                        <p id="modalDepartmentInfo" class="text-slate-700 font-medium"></p>
                    </div>
                    <div>
                        <p class="text-slate-400">Position</p>
                        <p id="modalPositionInfo" class="text-slate-700 font-medium"></p>
                    </div>
                    <div>
                        <p class="text-slate-400">Date Joined</p>
                        <p id="modalJoined" class="text-slate-700 font-medium"></p>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-slate-400">Address</p>
                        <p id="modalAddress" class="text-slate-700 font-medium"></p>
                    </div>
                </div>
            </div>

            <!-- Quick statistics section -->
            <div class="px-6 pb-6">
                <h3 class="text-sm font-semibold text-slate-700 mb-3 uppercase tracking-wide">
                    Quick Statistics
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="bg-slate-50 rounded-lg p-3 text-center">
                        <p id="modalPresent" class="text-lg font-semibold text-slate-800"></p>
                        <p class="text-xs text-slate-500 mt-1">Present Days</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-3 text-center">
                        <p id="modalLeave" class="text-lg font-semibold text-slate-800"></p>
                        <p class="text-xs text-slate-500 mt-1">Leave Taken</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-3 text-center">
                        <p id="modalSalary" class="text-lg font-semibold text-slate-800"></p>
                        <p class="text-xs text-slate-500 mt-1">Salary</p>
                    </div>
                    <div class="bg-slate-50 rounded-lg p-3 text-center">
                        <p id="modalProjects" class="text-lg font-semibold text-slate-800"></p>
                        <p class="text-xs text-slate-500 mt-1">Projects</p>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 px-6 pb-6">
                <button
                    id="closeModalBtnBottom"
                    class="flex-1 px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition-colors text-sm font-medium"
                >
                    Close
                </button>
                <a
                    href="#"
                    class="flex-1 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-colors text-sm font-medium text-center"
                >
                    View Full Profile
                </a>
            </div>
        </div>
    </div>

    <script>
        // Grab all the elements we need to work with.
        const employeeCards = document.querySelectorAll('.employee-card');
        const modalOverlay = document.getElementById('modalOverlay');
        const modalBox = document.getElementById('modalBox');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeModalBtnBottom = document.getElementById('closeModalBtnBottom');

        // Opens the modal and fills it with the clicked employee's data.
        function openModal(card) {
            const status = card.dataset.status;

            // Fill in the top section.
            document.getElementById('modalImage').src = card.dataset.image;
            document.getElementById('modalImage').alt = card.dataset.name;
            document.getElementById('modalName').textContent = card.dataset.name;
            document.getElementById('modalPosition').textContent = card.dataset.position;
            document.getElementById('modalDepartment').textContent = card.dataset.department;

            // Set the status badge text and color based on Active/Inactive.
            const statusBadge = document.getElementById('modalStatus');
            statusBadge.textContent = status;
            if (status === 'Active') {
                statusBadge.className = 'inline-block mt-2 px-3 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700';
            } else {
                statusBadge.className = 'inline-block mt-2 px-3 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700';
            }

            // Fill in the information section.
            document.getElementById('modalId').textContent = card.dataset.id;
            document.getElementById('modalEmail').textContent = card.dataset.email;
            document.getElementById('modalPhone').textContent = card.dataset.phone;
            document.getElementById('modalDepartmentInfo').textContent = card.dataset.department;
            document.getElementById('modalPositionInfo').textContent = card.dataset.position;
            document.getElementById('modalJoined').textContent = card.dataset.joined;
            document.getElementById('modalAddress').textContent = card.dataset.address;

            // Fill in the quick statistics section.
            document.getElementById('modalPresent').textContent = card.dataset.present;
            document.getElementById('modalLeave').textContent = card.dataset.leave;
            document.getElementById('modalSalary').textContent = card.dataset.salary;
            document.getElementById('modalProjects').textContent = card.dataset.projects;

            // Show the overlay first (remove "hidden"), then animate it in.
            // The small delay lets the browser register the starting state
            // before we transition to the final state (fade in + scale up).
            modalOverlay.classList.remove('hidden');
            setTimeout(() => {
                modalOverlay.classList.remove('opacity-0');
                modalBox.classList.remove('scale-95');
                modalBox.classList.add('scale-100');
            }, 10);

            // Prevent the page from scrolling behind the modal.
            document.body.classList.add('overflow-hidden');
        }

        // Closes the modal and reverses the animation.
        function closeModal() {
            // Animate back out first...
            modalOverlay.classList.add('opacity-0');
            modalBox.classList.remove('scale-100');
            modalBox.classList.add('scale-95');

            // ...then actually hide it once the animation finishes (200ms).
            setTimeout(() => {
                modalOverlay.classList.add('hidden');
            }, 200);

            // Allow the page to scroll again.
            document.body.classList.remove('overflow-hidden');
        }

        // Open modal when a card is clicked.
        employeeCards.forEach((card) => {
            card.addEventListener('click', () => openModal(card));
        });

        // Close modal when the X button is clicked.
        closeModalBtn.addEventListener('click', closeModal);

        // Close modal when the bottom "Close" button is clicked.
        closeModalBtnBottom.addEventListener('click', closeModal);

        // Close modal when clicking outside the modal box (on the dark overlay).
        modalOverlay.addEventListener('click', (event) => {
            if (event.target === modalOverlay) {
                closeModal();
            }
        });

        // Close modal when the Escape key is pressed.
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !modalOverlay.classList.contains('hidden')) {
                closeModal();
            }
        });
    </script>

</body>
</html>