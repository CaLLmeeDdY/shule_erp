<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Student List') }}
            </h2>
            <a href="{{ route('admissions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow">
                <i class="fas fa-plus mr-2"></i> New Admission
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-slate-900 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Adm No.</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Class Info</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Parent Info</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($students as $student)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full object-cover border" src="{{ $student->photo_url }}" alt="">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $student->full_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $student->gender }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $student->adm_number }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="font-bold text-gray-900">
                                        {{ $student->schoolClass->name ?? $student->class_applied }}
                                    </div>
                                    
                                    @if($student->schoolClass && $student->schoolClass->teacher)
                                        <div class="text-xs text-purple-600 font-semibold">
                                            Tr. {{ $student->schoolClass->teacher->name }}
                                        </div>
                                    @endif

                                    @if($student->stream)
                                        <div class="text-xs text-blue-600 mt-1">
                                            Stream: {{ $student->stream->name }}
                                        </div>
                                    @endif
                                    
                                    <span class="block text-xs text-gray-400 mt-1">{{ $student->study_mode }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    <div class="text-sm text-gray-900">{{ $student->parent_name }}</div>
                                    <div class="text-xs text-gray-500">{{ $student->parent_phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        {{ $student->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('students.show', $student->id) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    No students found. <a href="{{ route('admissions.create') }}" class="text-blue-600 underline">Add one now?</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $students->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>