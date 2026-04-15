<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Student Profile: <span class="text-blue-600 font-mono">{{ $student->adm_number }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow text-center">
                        <div class="h-32 w-32 bg-gray-200 rounded-full mx-auto flex items-center justify-center mb-4 overflow-hidden border-4 border-white shadow">
                            @if($student->passport_photo_path)
                                <img src="{{ asset('storage/' . $student->passport_photo_path) }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-4xl text-gray-400"><i class="fas fa-user"></i></span>
                            @endif
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $student->full_name }}</h2>
                        <p class="text-sm text-gray-500">{{ $student->class_applied }} • {{ $student->study_mode }}</p>
                        <div class="mt-4">
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">{{ $student->status }}</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-gray-700 mb-4 text-sm uppercase">Quick Actions</h3>
                        <div class="space-y-2">
                            <button class="w-full bg-blue-50 text-blue-700 py-2 rounded text-sm font-bold hover:bg-blue-100 text-left px-4">
                                <i class="fas fa-edit mr-2"></i> Edit Student
                            </button>
                            <button class="w-full bg-red-50 text-red-700 py-2 rounded text-sm font-bold hover:bg-red-100 text-left px-4">
                                <i class="fas fa-ban mr-2"></i> Suspend Student
                            </button>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">
                    
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-lg text-slate-800 border-b pb-2 mb-4">
                            <i class="fas fa-id-card text-blue-500 mr-2"></i> Personal Details
                        </h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Date of Birth</span>
                                <span class="font-bold">{{ $student->dob }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Gender</span>
                                <span class="font-bold">{{ $student->gender }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Nationality</span>
                                <span class="font-bold">{{ $student->nationality }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Birth Cert / ID</span>
                                <span class="font-bold">{{ $student->birth_cert_number ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-lg text-slate-800 border-b pb-2 mb-4">
                            <i class="fas fa-user-shield text-green-500 mr-2"></i> Guardian Information
                        </h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Guardian Name</span>
                                <span class="font-bold">{{ $student->parent_name }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Relationship</span>
                                <span class="font-bold">{{ $student->parent_relation }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Phone Number</span>
                                <span class="font-bold text-blue-600">{{ $student->parent_phone }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Home Location</span>
                                <span class="font-bold">{{ $student->home_location ?? 'Not Recorded' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow opacity-75">
                        <h3 class="font-bold text-lg text-slate-800 border-b pb-2 mb-4">
                            <i class="fas fa-graduation-cap text-purple-500 mr-2"></i> Academic History
                        </h3>
                        <div class="text-sm text-gray-500 mb-4">
                            <p><strong>Previous School:</strong> {{ $student->previous_school ?? 'N/A' }}</p>
                            <p><strong>KCPE Index:</strong> {{ $student->kcpe_index ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded text-xs text-yellow-800">
                            <strong>Note:</strong> Detailed Grades, Subject Performance, and Club Membership will appear here once the <em>Academic Module</em> is activated.
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>