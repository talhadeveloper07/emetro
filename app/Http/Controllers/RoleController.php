<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->get();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);
        // Convert permission IDs to permission names
        $permissionNames = Permission::whereIn('id', $request->permissions ?? [])
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        /*if (in_array($role->name, ['Admin', 'Super Admin', 'Customer'])) {
            return redirect()->route('roles.index')
                ->with('error', 'Cannot change name of protected role: ' . $role->name);
        }*/
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $permissionNames = Permission::whereIn('id', $request->permissions ?? [])
            ->pluck('name')
            ->toArray();

        $role->syncPermissions($permissionNames);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        // Prevent deletion of protected roles
        if (in_array($role->name, ['Admin', 'Super Admin', 'Customer'])) {
            return redirect()->route('roles.index')
                ->with('error', 'Cannot delete protected role: ' . $role->name);
        }

        // Check if role has users assigned
        if ($role->users()->exists()) {
            return redirect()->route('roles.index')
                ->with('error', 'Cannot delete role with assigned users. Reassign users first.');
        }

        $role->syncPermissions([]); // Remove all permissions first
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
