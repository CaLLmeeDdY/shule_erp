<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Staff Profile: <span class="text-blue-600 font-mono">{{ $staff->staff_number }}</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow text-center border-t-4 border-blue-600">
                        <div class="h-32 w-32 bg-gray-200 rounded-full mx-auto flex items-center justify-center mb-4 overflow-hidden border-4 border-white shadow">
                            @if($staff->passport_photo_path)
                                <img src="{{ asset('storage/' . $staff->passport_photo_path) }}" class="h-full w-full object-cover">
                            @else
                                <span class="text-4xl text-gray-400"><i class="fas fa-user-tie"></i></span>
                            @endif
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $staff->full_name }}</h2>
                        <div class="text-sm font-bold text-blue-600 uppercase tracking-wide mb-1">{{ $staff->position }}</div>
                        <p class="text-xs text-gray-500">{{ $staff->department }} Dept.</p>
                        
                        <div class="mt-4 pt-4 border-t border-gray-100 flex justify-between text-xs">
                            <span class="text-gray-500">Status</span>
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-bold">{{ $staff->status }}</span>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-gray-700 mb-4 text-xs uppercase border-b pb-2">Contact Details</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-phone text-gray-400 w-4"></i>
                                <span class="font-medium">{{ $staff->phone_number }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-envelope text-gray-400 w-4"></i>
                                <span class="font-medium">{{ $staff->email ?? 'No Email' }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fas fa-map-marker-alt text-gray-400 w-4"></i>
                                <span class="font-medium">{{ $staff->residence ?? 'No Residence' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 space-y-6">
                    
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="font-bold text-lg text-slate-800 border-b pb-2 mb-4 flex items-center gap-2">
                            <i class="fas fa-briefcase text-blue-500"></i> Employment & Qualifications
                        </h3>
                        <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-sm">
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">National ID</span>
                                <span class="font-bold">{{ $staff->national_id_number }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Employment Type</span>
                                <span class="font-bold">{{ $staff->employment_type }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Date Joined</span>
                                <span class="font-bold">{{ $staff->joining_date }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">Highest Qualification</span>
                                <span class="font-bold">{{ $staff->highest_qualification ?? 'N/A' }}</span>
                            </div>
                            
                            @if($staff->role == 'Teacher')
                            <div class="col-span-2 bg-blue-50 p-3 rounded border border-blue-100 mt-2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="block text-blue-500 text-xs uppercase font-bold">TSC Number</span>
                                        <span class="font-bold text-gray-800">{{ $staff->tsc_number ?? 'Pending' }}</span>
                                    </div>
                                    <div>
                                        <span class="block text-blue-500 text-xs uppercase font-bold">Subject Specialization</span>
                                        <span class="font-bold text-gray-800">{{ $staff->subjects_specialization ?? 'General' }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex justify-between items-center border-b pb-2 mb-4">
                            <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                                <i class="fas fa-file-invoice-dollar text-green-500"></i> Payroll & Statutory
                            </h3>
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded font-bold"><i class="fas fa-lock mr-1"></i> CONFIDENTIAL</span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-y-4 gap-x-8 text-sm">
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">KRA PIN</span>
                                <span class="font-mono font-bold">{{ $staff->kra_pin ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">NSSF Number</span>
                                <span class="font-mono font-bold">{{ $staff->nssf_no ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="block text-gray-500 text-xs uppercase">NHIF Number</span>
                                <span class="font-mono font-bold">{{ $staff->nhif_no ?? 'N/A' }}</span>
                            </div>
                            <div class="col-span-2 border-t mt-2 pt-2">
                                <span class="block text-gray-500 text-xs uppercase">Bank Details</span>
                                <div class="font-bold">{{ $staff->bank_name }}</div>
                                <div class="font-mono text-gray-600">{{ $staff->bank_account_no }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button class="bg-slate-800 text-white px-4 py-2 rounded text-sm font-bold hover:bg-slate-700">
                            <i class="fas fa-edit mr-2"></i> Edit Record
                        </button>
                        <button class="bg-red-50 text-red-600 px-4 py-2 rounded text-sm font-bold border border-red-200 hover:bg-red-100">
                            Suspend Staff
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>