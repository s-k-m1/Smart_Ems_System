@extends('CoreSystem.layouts.app')

@section('title', 'Create Notification')

@section('content')

<div class="px-4 sm:px-8 py-4 sm:py-8">

    <div class="bg-white rounded-2xl shadow-lg">

        <!-- Header -->
        <div class="border-b px-4 sm:px-8 py-4 sm:py-6">

            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                Create Notification
            </h1>

            <p class="text-gray-500 mt-2 text-sm sm:text-base">
                Publish a new notice for employees.
            </p>

        </div>

        <form action="{{ route('notifications.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="p-4 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-6">

                <!-- Title -->
                <div class="sm:col-span-2">
                    <label class="block font-semibold mb-2 text-sm sm:text-base">
                        Title
                    </label>

                    <input
                        type="text"
                        name="title"
                        value="{{ old('title') }}"
                        class="w-full border rounded-lg p-3 text-sm sm:text-base"
                        placeholder="Annual Leave Policy Update">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="sm:col-span-2">

                    <label class="block font-semibold mb-2 text-sm sm:text-base">
                        Description
                    </label>

                    <textarea
                        name="description"
                        rows="6"
                        class="w-full border rounded-lg p-3 text-sm sm:text-base"
                        placeholder="Enter notification description...">{{ old('description') }}</textarea>

                </div>

                <!-- Category -->
                <div>

                    <label class="block font-semibold mb-2 text-sm sm:text-base">
                        Category
                    </label>

                    <select
                        name="category"
                        class="w-full border rounded-lg p-3 text-sm sm:text-base">

                        <option value="Company">Company</option>
                        <option value="HR">HR</option>
                        <option value="Payroll">Payroll</option>
                        <option value="Policies">Policies</option>
                        <option value="Training">Training</option>
                        <option value="Events">Events</option>

                    </select>

                </div>

                <!-- Department -->
                <div>

                    <label class="block font-semibold mb-2 text-sm sm:text-base">
                        Department
                    </label>

                    <input
                        type="text"
                        name="department"
                        value="{{ old('department') }}"
                        class="w-full border rounded-lg p-3 text-sm sm:text-base"
                        placeholder="Human Resource Department">

                </div>

                <!-- Priority -->
                <div>

                    <label class="block font-semibold mb-2 text-sm sm:text-base">
                        Priority
                    </label>

                    <select
                        name="priority"
                        class="w-full border rounded-lg p-3 text-sm sm:text-base">

                        <option value="Low">Low</option>
                        <option value="Medium" selected>Medium</option>
                        <option value="High">High</option>

                    </select>

                </div>

                <!-- Published By -->
                <div>

                    <label class="block font-semibold mb-2 text-sm sm:text-base">
                        Published By
                    </label>

                    <input
                        type="text"
                        name="published_by"
                        value="{{ old('published_by') }}"
                        class="w-full border rounded-lg p-3 text-sm sm:text-base"
                        placeholder="HR Manager">

                </div>

                <!-- Publish Date -->
                <div>

                    <label class="block font-semibold mb-2 text-sm sm:text-base">
                        Publish Date
                    </label>

                    <input
                        type="datetime-local"
                        name="publish_date"
                        class="w-full border rounded-lg p-3 text-sm sm:text-base">

                </div>

                <!-- Attachment -->
                <div>

                    <label class="block font-semibold mb-2 text-sm sm:text-base">
                        Attachment
                    </label>

                    <input
                        type="file"
                        name="attachment"
                        class="w-full border rounded-lg p-3 text-sm sm:text-base">

                </div>

                <!-- Pin Notification -->
                <div class="sm:col-span-2">

                    <label class="inline-flex items-center">

                        <input
                            type="checkbox"
                            name="is_pinned"
                            value="1"
                            class="w-5 h-5 rounded">

                        <span class="ml-3 font-medium text-sm sm:text-base">
                            Pin this Notification
                        </span>

                    </label>

                </div>

            </div>

            <!-- Buttons -->
            <div class="border-t px-4 sm:px-8 py-6 flex flex-col sm:flex-row justify-end gap-3">

                <a href="{{ route('notifications.index') }}"
                   class="w-full sm:w-auto text-center px-6 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 text-sm sm:text-base">

                    Cancel

                </a>

                <button
                    type="submit"
                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-sm sm:text-base">

                    Publish Notification

                </button>

            </div>

        </form>

    </div>

</div>

@endsection
