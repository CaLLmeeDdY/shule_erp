<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
    /**
     * 1. SHOW STAFF LIST (With Filters)
     */
    public function index(Request $request)
    {
        $query = Staff::query();

        // Search by Name or Staff ID
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%')
                  ->orWhere('staff_number', 'like', '%' . $request->search . '%');
        }

        // Filter by Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $staff = $query->latest()->paginate(10);

        return view('staff.index', compact('staff'));
    }

    /**
     * 2. SHOW ONBOARDING FORM
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * 3. SAVE NEW STAFF
     */
    public function store(Request $request)
    {
        // A. VALIDATE
        $validated = $request->validate([
            // Identity
            'staff_number' => 'required|unique:staff,staff_number',
            'full_name' => 'required',
            'national_id_number' => 'required|unique:staff,national_id_number',
            'gender' => 'required',
            'passport_photo' => 'nullable|image|max:2048',

            // Contact
            'phone_number' => 'required',
            'email' => 'nullable|email',
            
            // Employment
            'role' => 'required',
            'department' => 'required',
            'position' => 'required',
            'employment_type' => 'required',
            'joining_date' => 'required|date',

            // Payroll & Tax
            'kra_pin' => 'nullable',
            'tsc_number' => 'nullable',
        ]);

        // B. HANDLE PHOTO
        if ($request->hasFile('passport_photo')) {
            $path = $request->file('passport_photo')->store('staff_photos', 'public');
            $validated['passport_photo_path'] = $path;
        }

        // C. SAVE EXTRA FIELDS
        $staff = new Staff($validated);
        $staff->residence = $request->residence;
        $staff->highest_qualification = $request->highest_qualification;
        $staff->subjects_specialization = $request->subjects_specialization;
        $staff->tsc_number = $request->tsc_number;
        $staff->kra_pin = $request->kra_pin;
        $staff->nssf_no = $request->nssf_no;
        $staff->nhif_no = $request->nhif_no;
        $staff->bank_name = $request->bank_name;
        $staff->bank_account_no = $request->bank_account_no;
        $staff->status = 'Active';
        $staff->save();

        return redirect()->route('staff.index')->with('success', 'Staff Onboarded Successfully: ' . $staff->staff_number);
    }

    /**
     * 4. SHOW STAFF PROFILE (Digital Personnel File)
     */
    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }
}