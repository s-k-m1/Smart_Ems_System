@extends('CoreSystem.layouts.app')

@section('title', 'Edit Employee')

@section('content')

<header class="bg-white border-b border-slate-200">
    <div class="px-4 sm:px-8 py-4 sm:py-6">
        <h1 class="text-2xl font-semibold text-slate-800">Edit Employee</h1>
        <p class="text-sm text-slate-500 mt-1">Update {{ $employee->name }}'s details</p>
    </div>
    </header>

    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if ($errors->any())
            <div class="mb-6 px-4 py-3 rounded-lg bg-red-100 text-red-700 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('employees.update', $employee->id) }}" method="POST" class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Employee ID</label>
                    <input type="text" name="employee_id" value="{{ old('employee_id', $employee->employee_id) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Department</label>
                    <input type="text" name="department" value="{{ old('department', $employee->department) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Position</label>
                    <input type="text" name="position" value="{{ old('position', $employee->position) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="Active" {{ old('status', $employee->status) === 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('status', $employee->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Date Joined</label>
                    <input type="date" name="joined" value="{{ old('joined', $employee->joined->format('Y-m-d')) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Address</label>
                    <input type="text" name="address" value="{{ old('address', $employee->address) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Photo URL</label>
                    <input type="text" name="image" value="{{ old('image', $employee->image) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Present Days</label>
                    <input type="number" name="present_days" value="{{ old('present_days', $employee->present_days) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Leave Taken</label>
                    <input type="number" name="leave_taken" value="{{ old('leave_taken', $employee->leave_taken) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Salary (Rs.)</label>
                    <input type="number" step="0.01" name="salary" value="{{ old('salary', $employee->salary) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Projects</label>
                    <input type="number" name="projects" value="{{ old('projects', $employee->projects) }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('employees.index') }}" class="flex-1 px-4 py-2 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 text-sm font-medium text-center">Cancel</a>
                <button type="submit" class="flex-1 px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 text-sm font-medium">Update Employee</button>
            </div>
        </form>
    </main>
@endsection