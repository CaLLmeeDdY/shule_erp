<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Student Admission') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Whoops!</strong> There were some problems with your input.
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admissions.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-xl rounded-lg overflow-hidden">
                @csrf

                <div class="px-6 py-4 bg-slate-900 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-white">1. Student Personal Details</h3>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50">
                    <div class="md:col-span-3 flex flex-col items-center justify-center mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Passport Photo</label>
                        <div class="flex items-center space-x-4">
                            <div class="shrink-0">
                                <img id="preview_img" class="h-24 w-24 object-cover rounded-full border-2 border-gray-300" src="https://ui-avatars.com/api/?name=New+Student&background=random" alt="Current profile photo" />
                            </div>
                            <label class="block">
                                <span class="sr-only">Choose profile photo</span>
                                <input type="file" name="passport_photo" onchange="loadFile(event)" class="block w-full text-sm text-slate-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-blue-50 file:text-blue-700
                                  hover:file:bg-blue-100
                                "/>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Admission Number</label>
                        <input type="text" name="adm_number" value="{{ old('adm_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. ADM-2024-001" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="John Doe" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                        <input type="date" name="dob" value="{{ old('dob') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="gender" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nationality</label>
                        <input type="text" name="nationality" value="{{ old('nationality', 'Kenyan') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Birth Cert No. / NEMIS</label>
                        <input type="text" name="birth_cert_number" value="{{ old('birth_cert_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Home Location / Estate</label>
                        <input type="text" name="home_location" value="{{ old('home_location') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-900 border-t border-b border-gray-200 mt-6">
                    <h3 class="text-lg font-medium text-white">2. Parent / Guardian Information</h3>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 bg-white">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Parent/Guardian Name</label>
                        <input type="text" name="parent_name" value="{{ old('parent_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Relationship</label>
                        <select name="parent_relation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="Father">Father</option>
                            <option value="Mother">Mother</option>
                            <option value="Guardian">Guardian</option>
                            <option value="Sponsor">Sponsor</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="parent_phone" value="{{ old('parent_phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">ID Number (Optional)</label>
                        <input type="text" name="guardian_id_number" value="{{ old('guardian_id_number') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="px-6 py-4 bg-slate-900 border-t border-b border-gray-200 mt-6">
                    <h3 class="text-lg font-medium text-white">3. Academic History & Placement</h3>
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Previous School</label>
                        <input type="text" name="previous_school" value="{{ old('previous_school') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">KCPE / Assessment Index</label>
                        <input type="text" name="kcpe_index" value="{{ old('kcpe_index') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Grade / Marks</label>
                        <input type="text" name="last_grade_completed" value="{{ old('last_grade_completed') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g. 350 Marks or Grade B">
                    </div>

                    <div class="border-t border-gray-300 col-span-1 md:col-span-3 my-2"></div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Class Admitted To</label>
                        <select name="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->name }} 
                                    @if($class->teacher)
                                       (Tr. {{ $class->teacher->name }})
                                    @else
                                       (No Teacher Assigned)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Stream (Optional)</label>
                        <select name="stream_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select Stream</option>
                            @foreach($streams as $stream)
                                <option value="{{ $stream->id }}">{{ $stream->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Study Mode</label>
                        <select name="study_mode" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="Day Scholar">Day Scholar</option>
                            <option value="Boarding">Boarding</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Intake Term</label>
                        <select name="intake_term" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="Term 1">Term 1</option>
                            <option value="Term 2">Term 2</option>
                            <option value="Term 3">Term 3</option>
                        </select>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-100 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-lg transform transition hover:scale-105">
                        Complete Admission
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        var loadFile = function(event) {
            var output = document.getElementById('preview_img');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>
</x-app-layout>