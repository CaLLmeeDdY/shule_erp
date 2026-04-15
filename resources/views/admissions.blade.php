<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Student Admission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p class="font-bold">Success!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admissions') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-slate-700 border-b pb-2 mb-4">
                        <i class="fas fa-user text-blue-500 mr-2"></i> 1. Student Identity
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700">Admission Number <span class="text-red-500">*</span></label>
                            <input type="text" name="adm_number" value="{{ old('adm_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. ADM-2026-001" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Full Official Name <span class="text-red-500">*</span></label>
                            <input type="text" name="full_name" value="{{ old('full_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date of Birth <span class="text-red-500">*</span></label>
                            <input type="date" name="dob" value="{{ old('dob') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nationality</label>
                            <select name="nationality" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option>Kenyan</option>
                                <option>Ugandan</option>
                                <option>Tanzanian</option>
                                <option>South Sudanese</option>
                                <option>Other</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Birth Cert / ID No.</label>
                            <input type="text" name="birth_cert_number" value="{{ old('birth_cert_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Passport Photo</label>
                            <input type="file" name="passport_photo" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-slate-700 border-b pb-2 mb-4">
                        <i class="fas fa-users text-green-500 mr-2"></i> 2. Guardian & Contact
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Guardian Full Name <span class="text-red-500">*</span></label>
                            <input type="text" name="parent_name" value="{{ old('parent_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Relationship <span class="text-red-500">*</span></label>
                            <select name="parent_relation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option>Father</option>
                                <option>Mother</option>
                                <option>Guardian</option>
                                <option>Sponsor</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Phone Number <span class="text-red-500">*</span></label>
                            <input type="text" name="parent_phone" value="{{ old('parent_phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="07..." required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Guardian National ID</label>
                            <input type="text" name="guardian_id_number" value="{{ old('guardian_id_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Home Location / Estate</label>
                            <input type="text" name="home_location" value="{{ old('home_location') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-bold text-slate-700 border-b pb-2 mb-4">
                        <i class="fas fa-graduation-cap text-purple-500 mr-2"></i> 3. Academic & Placement
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Previous School</label>
                            <input type="text" name="previous_school" value="{{ old('previous_school') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">KCPE / Index No</label>
                            <input type="text" name="kcpe_index" value="{{ old('kcpe_index') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Grade</label>
                            <input type="text" name="last_grade_completed" value="{{ old('last_grade_completed') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. Class 8">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Class Admitted To <span class="text-red-500">*</span></label>
                            <select name="class_applied" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option>Form 1</option>
                                <option>Form 2</option>
                                <option>Form 3</option>
                                <option>Form 4</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stream</label>
                            <input type="text" name="stream" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="e.g. North">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700">Study Mode <span class="text-red-500">*</span></label>
                            <select name="study_mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                <option>Day Scholar</option>
                                <option>Boarding</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="w-full md:w-auto bg-slate-900 hover:bg-slate-800 text-white font-bold py-3 px-8 rounded shadow-lg transition transform hover:scale-105">
                        <i class="fas fa-check-circle mr-2"></i> COMPLETE ADMISSION
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>