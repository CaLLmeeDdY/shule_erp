<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Staff Onboarding</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('staff.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-bold text-gray-700 border-b pb-2 mb-4">1. Identity & Contact</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold">Staff ID (Unique)</label>
                            <input type="text" name="staff_number" class="w-full border-gray-300 rounded" placeholder="e.g. STF-001" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Full Name</label>
                            <input type="text" name="full_name" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">National ID No</label>
                            <input type="text" name="national_id_number" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Phone Number</label>
                            <input type="text" name="phone_number" class="w-full border-gray-300 rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Gender</label>
                            <select name="gender" class="w-full border-gray-300 rounded">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Passport Photo</label>
                            <input type="file" name="passport_photo" class="w-full text-sm">
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-bold text-gray-700 border-b pb-2 mb-4">2. Employment Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold">Role / Access Level</label>
                            <select name="role" class="w-full border-gray-300 rounded">
                                <option>Teacher</option>
                                <option>Bursar / Accounts</option>
                                <option>Admin / Secretary</option>
                                <option>Support Staff</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Department</label>
                            <select name="department" class="w-full border-gray-300 rounded">
                                <option>Sciences</option>
                                <option>Humanities</option>
                                <option>Languages</option>
                                <option>Administration</option>
                                <option>Transport / Kitchen</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Position Title</label>
                            <input type="text" name="position" class="w-full border-gray-300 rounded" placeholder="e.g. Senior Teacher">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Employment Type</label>
                            <select name="employment_type" class="w-full border-gray-300 rounded">
                                <option>Permanent & Pensionable</option>
                                <option>Contract</option>
                                <option>Internship</option>
                                <option>Casual</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Date of Joining</label>
                            <input type="date" name="joining_date" class="w-full border-gray-300 rounded" required>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <h3 class="font-bold text-gray-700 border-b pb-2 mb-4">3. Payroll & Qualifications</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium">KRA PIN</label>
                            <input type="text" name="kra_pin" class="w-full border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">TSC Number (If Teacher)</label>
                            <input type="text" name="tsc_number" class="w-full border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">NSSF No</label>
                            <input type="text" name="nssf_no" class="w-full border-gray-300 rounded">
                        </div>
                        <div>
                            <label class="block text-sm font-medium">NHIF No</label>
                            <input type="text" name="nhif_no" class="w-full border-gray-300 rounded">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium">Subjects (If Teacher)</label>
                            <input type="text" name="subjects_specialization" class="w-full border-gray-300 rounded" placeholder="e.g. Maths, Physics">
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-blue-600 text-white font-bold py-3 px-8 rounded shadow hover:bg-blue-700">
                        CONFIRM & ONBOARD STAFF
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>