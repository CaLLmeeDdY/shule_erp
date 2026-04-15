<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Staff; // We need this to link Staff to Users
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolePermissionController extends Controller
{
    public function index()
    {
        // 1. Get Users (for the table)
        // We show ALL users so you can see yourself too.
        $users = User::with('roles')->get();

        // 2. Get Roles (for the settings)
        $roles = Role::with('permissions')->get();

        // 3. Get Permissions (Grouped for the nice checkbox UI)
        $permissions = Permission::all()->groupBy(function($perm) {
            return explode(' ', $perm->name)[1] ?? 'System'; // Group by "students", "finance", etc.
        });

        // 4. Get Staff who DON'T have a user account yet (for the "Create Account" dropdown)
        // We look for staff emails that do not exist in the users table
        $existingEmails = User::pluck('email')->toArray();
        $unregisteredStaff = Staff::whereNotIn('email', $existingEmails)->get();

        return view('admin.roles.index', compact('users', 'roles', 'permissions', 'unregisteredStaff'));
    }

    // Assign a Role to a User
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::find($request->user_id);
        
        // Prevent disabling your own Super Admin account
        if ($user->id === auth()->id() && $user->hasRole('Super Admin') && $request->role !== 'Super Admin') {
            return back()->with('error', 'Security Alert: You cannot remove your own Super Admin status.');
        }

        $user->syncRoles([$request->role]);
        return back()->with('success', "Role updated for {$user->name}.");
    }

    // Define Permissions for a Role (The Checkboxes)
    public function updatePermissions(Request $request, Role $role)
    {
        // If "Super Admin", don't change anything (they always have all power)
        if($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin permissions cannot be modified.');
        }

        $role->syncPermissions($request->permissions ?? []);
        return back()->with('success', "Permissions updated for {$role->name}.");
    }

    // Create a User Account for a Staff Member
    public function createStaffAccount(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'password' => 'required|min:6'
        ]);

        $staff = Staff::find($request->staff_id);

        // Create the User
        $user = User::create([
            'name' => $staff->full_name,
            'email' => $staff->email,
            'password' => Hash::make($request->password),
        ]);

        // Auto-assign 'Teacher' role if they are a teacher, otherwise 'Staff'
        $role = str_contains(strtolower($staff->position), 'teacher') ? 'Teacher' : 'Staff';
        // Check if role exists, if not create it
        if (!Role::where('name', $role)->exists()) {
             Role::create(['name' => $role]);
        }
        $user->assignRole($role);

        return back()->with('success', "Login account created for {$staff->full_name}!");
    }
    
    public function storeRole(Request $request)
    {
        $request->validate(['name' => 'required|unique:roles,name']);
        Role::create(['name' => $request->name]);
        return back()->with('success', 'New Role created.');
    }

    // UPDATE SYSTEM SETTINGS (Logo, Name, Slogans)
    public function updateSettings(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_slogan' => 'nullable|string|max:255',
            'school_motto' => 'nullable|string|max:255',
            'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // 1. Update Text Fields
        $fields = ['school_name', 'school_slogan', 'school_motto'];
        foreach($fields as $field) {
            \App\Models\SystemSetting::updateOrCreate(
                ['key' => $field],
                ['value' => $request->input($field)]
            );
        }

        // 2. Handle Logo Upload
        if ($request->hasFile('school_logo')) {
            // Delete old logo if exists (optional cleanup)
            
            // Store new logo in 'public/logos'
            $path = $request->file('school_logo')->store('logos', 'public');
            
            \App\Models\SystemSetting::updateOrCreate(
                ['key' => 'school_logo'],
                ['value' => $path]
            );
        }

        return back()->with('success', 'System Branding Updated Successfully!');
    }
}