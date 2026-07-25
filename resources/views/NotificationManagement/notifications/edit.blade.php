@extends('CoreSystem.layouts.app')

@section('title', 'Edit Notification')

@section('content')

<div class="px-8 py-8">

    <div class="bg-white rounded-2xl shadow-lg">

        <div class="border-b px-8 py-6">

            <h1 class="text-3xl font-bold text-slate-800">
                Edit Notification
            </h1>

            <p class="text-gray-500 mt-2">
                Update the selected notification.
            </p>

        </div>

        <form action="{{ route('notifications.update', $notification->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="p-8 grid grid-cols-2 gap-6">

                <div class="col-span-2">
                    <label class="block font-semibold mb-2">Title</label>
                    <input type="text" name="title"
                           value="{{ old('title', $notification->title) }}"
                           class="w-full border rounded-lg p-3"
                           placeholder="Annual Leave Policy Update">
                </div>

                <div class="col-span-2">
                    <label class="block font-semibold mb-2">Description</label>
                    <textarea name="description" rows="6"
                              class="w-full border rounded-lg p-3"
                              placeholder="Enter notification description...">{{ old('description', $notification->description) }}</textarea>
                </div>

                <div>
                    <label class="block font-semibold mb-2">Category</label>
                    <select name="category" class="w-full border rounded-lg p-3">
                        <option value="Company" {{ $notification->category == 'Company' ? 'selected' : '' }}>Company</option>
                        <option value="HR" {{ $notification->category == 'HR' ? 'selected' : '' }}>HR</option>
                        <option value="Payroll" {{ $notification->category == 'Payroll' ? 'selected' : '' }}>Payroll</option>
                        <option value="Policies" {{ $notification->category == 'Policies' ? 'selected' : '' }}>Policies</option>
                        <option value="Training" {{ $notification->category == 'Training' ? 'selected' : '' }}>Training</option>
                        <option value="Events" {{ $notification->category == 'Events' ? 'selected' : '' }}>Events</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2">Department</label>
                    <input type="text" name="department"
                           value="{{ old('department', $notification->department) }}"
                           class="w-full border rounded-lg p-3"
                           placeholder="Human Resource Department">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Priority</label>
                    <select name="priority" class="w-full border rounded-lg p-3">
                        <option value="Low" {{ $notification->priority == 'Low' ? 'selected' : '' }}>Low</option>
                        <option value="Medium" {{ $notification->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ $notification->priority == 'High' ? 'selected' : '' }}>High</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold mb-2">Published By</label>
                    <input type="text" name="published_by"
                           value="{{ old('published_by', $notification->published_by) }}"
                           class="w-full border rounded-lg p-3"
                           placeholder="HR Manager">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Publish Date</label>
                    <input type="datetime-local" name="publish_date"
                           value="{{ old('publish_date', $notification->publish_date->format('Y-m-d\TH:i')) }}"
                           class="w-full border rounded-lg p-3">
                </div>

                <div>
                    <label class="block font-semibold mb-2">Attachment</label>
                    <input type="file" name="attachment" class="w-full border rounded-lg p-3">
                    @if($notification->attachment)
                        <p class="text-sm text-gray-500 mt-1">Current: {{ $notification->attachment }}</p>
                    @endif
                </div>

                <div class="col-span-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="is_pinned" value="1"
                               class="w-5 h-5 rounded"
                               {{ $notification->is_pinned ? 'checked' : '' }}>
                        <span class="ml-3 font-medium">Pin this Notification</span>
                    </label>
                </div>

            </div>

            <div class="border-t px-8 py-6 flex justify-end gap-4">

                <a href="{{ route('notifications.index') }}"
                   class="px-6 py-3 rounded-lg bg-gray-200 hover:bg-gray-300">
                    Cancel
                </a>

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold">
                    Update Notification
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
