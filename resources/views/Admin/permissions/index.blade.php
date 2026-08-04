@extends('CoreSystem.layouts.app')

@section('title', 'Permission Management - Admin')

@section('content')
<header class="bg-white border-b border-slate-200 px-4 sm:px-8 py-4">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-800">Permission Management</h1>
            <p class="text-sm text-slate-500 mt-0.5">Define and assign permissions to HR and Employee roles</p>
        </div>
        <span class="text-xs text-slate-400">{{ now()->format('l, F j, Y') }}</span>
    </div>
</header>

<div class="p-4 sm:p-8 space-y-6">
    @if(session('success'))
    <div class="rounded-lg border border-green-300 bg-green-100 px-4 py-3 text-green-700">
        {{ session('success') }}
    </div>
    @endif

    {{-- Add Permission Form --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">Add New Permission</h2>
        <form action="{{ route('admin.permissions.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3 items-end">
            @csrf
            <div class="flex-1 w-full sm:w-auto">
                <label class="block text-sm font-medium text-slate-700 mb-1">Permission Name</label>
                <input type="text" name="name" required placeholder="e.g. view_payroll"
                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="flex-1 w-full sm:w-auto">
                <label class="block text-sm font-medium text-slate-700 mb-1">Label</label>
                <input type="text" name="label" placeholder="e.g. View Payroll"
                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="w-full sm:w-40">
                <label class="block text-sm font-medium text-slate-700 mb-1">Group</label>
                <input type="text" name="group" placeholder="e.g. payroll"
                    class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-medium hover:bg-indigo-700 transition shrink-0">
                Add Permission
            </button>
        </form>
    </div>

    {{-- Role Permission Assignment --}}
    @foreach($roles as $role)
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-slate-800">
                {{ ucfirst($role) }} Role Permissions
            </h2>
            <span class="text-xs text-slate-400">{{ count($rolePermissions[$role]) }} permissions assigned</span>
        </div>
        <form action="{{ route('admin.permissions.update') }}" method="POST">
            @csrf
            <input type="hidden" name="role" value="{{ $role }}">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($grouped as $groupName => $groupPermissions)
                    @foreach($groupPermissions as $perm)
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer transition">
                        <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                            {{ in_array($perm->name, $rolePermissions[$role]) ? 'checked' : '' }}
                            class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <div>
                            <span class="text-sm font-medium text-slate-700">{{ $perm->label ?? $perm->name }}</span>
                            <span class="block text-xs text-slate-400">{{ $perm->name }}</span>
                        </div>
                    </label>
                    @endforeach
                @endforeach
            </div>
            <div class="mt-4 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition">
                    Save {{ ucfirst($role) }} Permissions
                </button>
            </div>
        </form>
    </div>
    @endforeach

    {{-- Existing Permissions List --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 sm:p-6">
        <h2 class="text-lg font-semibold text-slate-800 mb-4">All Permissions</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="text-left py-3 px-3 font-medium text-slate-500">Name</th>
                        <th class="text-left py-3 px-3 font-medium text-slate-500">Label</th>
                        <th class="text-left py-3 px-3 font-medium text-slate-500">Group</th>
                        <th class="text-right py-3 px-3 font-medium text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permissions as $perm)
                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                        <td class="py-3 px-3 font-mono text-slate-700">{{ $perm->name }}</td>
                        <td class="py-3 px-3 text-slate-600">{{ $perm->label ?? '-' }}</td>
                        <td class="py-3 px-3">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">{{ $perm->group }}</span>
                        </td>
                        <td class="py-3 px-3 text-right">
                            <form action="{{ route('admin.permissions.destroy', $perm->id) }}" method="POST" onsubmit="return confirm('Delete this permission?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700 text-sm font-medium transition">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-6 text-center text-slate-400">No permissions defined yet.</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection