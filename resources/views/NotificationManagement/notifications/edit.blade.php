@extends('CoreSystem.layouts.app')

@section('title', 'Edit Notification')

@section('content')

<div class="px-4 sm:px-8 py-4 sm:py-8">

    <div class="bg-white rounded-2xl shadow-lg">

        <div class="border-b px-4 sm:px-8 py-4 sm:py-6">

            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                Edit Notification
            </h1>

            <p class="text-gray-500 mt-2 text-sm sm:text-base">
                Update the selected notification.
            </p>

        </div>

        <form action="{{ route('notifications.update', $notification->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="p-4 sm:p-8 grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div class="sm:col-span-2">
                    <label class="block font-semibold mb-2 text-sm sm:text-base">Title</label>
                    <input type="text" name="title"
                           value="{{ old('title', $notification->title) }}"
                           class="w-full border rounded-lg p-3 text-sm sm:text-base"
                           placeholder="Annual Leave Policy Update">
                </div>

                <div class="sm:col-span-2">
                    <label class="block font-semibold mb-2 text-sm sm:text-base">Description</label>
                    <textarea name="description" rows="6"
                              class="w-full border rounded-lg p-3 text-sm sm:text-base"
                              placeholder="Enter notification description...">{{ old('description', $notification->description) }}</textarea>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-sm sm:text-base">Category</label>
                    <select name="category" class="w-full border rounded-lg p-3 text-sm sm:text-base">
                        <option value="Company" {{ $notification->category == 'Company' ? 'selected' : '' }}>Company</option>
                        <option value="HR" {{ $notification->category == 'HR' ? 'selected' : '' }}>HR</option>
                        <option value="Payroll" {{ $notification->category == 'Payroll' ? 'selected' : '' }}>Payroll</option>
                        <option value="Policies" {{ $notification->category == 'Policies' ? 'selected' : '' }}>Policies</option>
                        <option value="Training" {{ $notification->category == 'Training' ? 'selected' : '' }}>Training</option>
                        <option value="Events" {{ $notification->category == 'Events' ? 'selected' : '' }}>Events</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-sm sm:text-base">Department</label>
                    <input type="text" name="department"
                           value="{{ old('department', $notification->department) }}"
                           class="w-full border rounded-lg p-3 text-sm sm:text-base"
                           placeholder="Human Resource Department">
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-sm sm:text-base">Priority</label>
                    <select name="priority" class="w-full border rounded-lg p-3 text-sm sm:text-base">
                        <option value="Low" {{ $notification->priority == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ $notification->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ $notification->priority == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-sm sm:text-base">Published By</label>
                    <input type="text" name="published_by"
                           value="{{ old('published_by', $notification->published_by) }}"
                           class="w-full border rounded-lg p-3 text-sm sm:text-base"
                           placeholder="HR Manager">
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-sm sm:text-base">Publish Date</label>
                    <input type="datetime-local" name="publish_date"
                           value="{{ old('publish_date', $notification->publish_date->format('Y-m-d\TH:i')) }}"
                           class="w-full border rounded-lg p-3 text-sm sm:text-base">
                </div>

                <div>
                    <label class="block font-semibold mb-2 text-sm sm:text-base">Attachment</label>
                    <input type="file" name="attachment" class="w-full border rounded-lg p-3 text-sm sm:text-base">
                    @if($notification->attachment)
                        <p class="text-sm text-gray-500 mt-1">Current: {{ $notification->attachment }}</p>
                    @endif
                </div>

                <div class="sm:col-span-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_pinned" value="1"
                               class="w-5 h-5 rounded"
                               {{ $notification->is_pinned ? 'checked' : '' }}>
                        <span class="ml-3 font-medium text-sm sm:text-base">Pin this Notification</span>
                    </label>
                </div>

            </div>

            <div class="border-t px-4 sm:px-8 py-6 flex flex-col sm:flex-row justify-end gap-3">

                <a href="{{ route('notifications.index') }}"
                   class="w-full sm:w-auto text-center px-6 py-3 rounded-lg bg-gray-200 hover:bg-gray-300 text-sm sm:text-base">
                    Cancel
                </a>

                <button type="submit"
                        class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-sm sm:text-base">
                    Update Notification
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
