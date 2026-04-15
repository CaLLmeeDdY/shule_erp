<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // 1. Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Define Permissions List
        $permissions = [
            // User Management (Admin Only)
            'manage users',
            'view system logs',

            // Student Management (Admissions)
            'view students',
            'admit students',
            'edit student records',
            'delete students',

            // Staff / HR
            'view staff',
            'add staff',
            'edit staff',
            'manage payroll',

            // Academics (Classes, Timetables, Subjects)
            'manage classes',
            'manage subjects',
            'manage timetables',
            'view timetables',

            // Exams & Grading
            'create exams',
            'enter marks',
            'edit marks',
            'publish results',
            'view results',

            // Finance (Fees)
            'collect fees',
            'view financial reports',
            'manage expenses',
        ];

        // 3. Create Permissions in Database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 4. Create Roles and Assign Permissions

        // ROLE A: TEACHER
        $teacherRole = Role::firstOrCreate(['name' => 'Teacher']);
        $teacherRole->syncPermissions([
            'view students',
            'view timetables',
            'view results',
            'enter marks', // Teachers can enter marks
            'view staff',  // To see colleagues
        ]);

        // ROLE B: ACCOUNTANT / BURSAR
        $accountantRole = Role::firstOrCreate(['name' => 'Accountant']);
        $accountantRole->syncPermissions([
            'view students',
            'collect fees',
            'view financial reports',
            'manage expenses',
            'view staff',
        ]);

        // ROLE C: SECRETARY / ADMISSIONS
        $secretaryRole = Role::firstOrCreate(['name' => 'Secretary']);
        $secretaryRole->syncPermissions([
            'view students',
            'admit students',
            'edit student records',
            'view staff',
            'view timetables',
        ]);

        // ROLE D: SUPER ADMIN (Gets everything)
        $adminRole = Role::firstOrCreate(['name' => 'Super Admin']);
        // The Super Admin gets ALL permissions
        $adminRole->givePermissionTo(Permission::all());
    }
}