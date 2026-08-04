<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('group')->orderBy('name')->get();
        $grouped = $permissions->groupBy('group');
        $roles = ['admin', 'hr', 'employee'];
        $rolePermissions = [];

        foreach ($roles as $role) {
            $rolePermissions[$role] = Permission::whereHas('roles', function ($query) use ($role) {
                $query->where('role', $role);
            })->pluck('name')->toArray();
        }

        return view('Admin.permissions.index', compact('permissions', 'grouped', 'roles', 'rolePermissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'label' => 'nullable|string|max:255',
            'group' => 'nullable|string|max:255',
        ]);

        Permission::create([
            'name' => $request->name,
            'label' => $request->label ?? $request->name,
            'group' => $request->group ?? 'general',
        ]);

        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'role' => 'required|string',
            'permissions' => 'array',
            'permissions.*' => 'string',
        ]);

        $role = $request->role;
        $permissionNames = $request->permissions ?? [];

        $existingPermissionIds = Permission::whereIn('name', $permissionNames)->pluck('id')->toArray();

        \DB::table('role_permissions')
            ->where('role', $role)
            ->delete();

        foreach ($existingPermissionIds as $permissionId) {
            \DB::table('role_permissions')->insert([
                'role' => $role,
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Permissions updated for ' . ucfirst($role) . ' role.');
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->back()->with('success', 'Permission deleted successfully.');
    }
}