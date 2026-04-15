<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Staff & HR Directory</h2>
            <a href="{{ route('staff.create') }}" class="bg-slate-900 text-white font-bold py-2 px-4 rounded hover:bg-slate-800">
                + Onboard New Staff
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-500">
                        <tr>
                            <th class="px-6 py-4">Staff ID</th>
                            <th class="px-6 py-4">Name & Role</th>
                            <th class="px-6 py-4">Department</th>
                            <th class="px-6 py-4">Contact</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($staff as $employee)
                        <tr>
                            <td class="px-6 py-4 font-mono font-bold text-blue-600">{{ $employee->staff_number }}</td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $employee->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $employee->position }}</div>
                            </td>
                            <td class="px-6 py-4">{{ $employee->department }}</td>
                            <td class="px-6 py-4">{{ $employee->phone_number }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-bold rounded-full">
                                    {{ $employee->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="text-blue-600 hover:underline">
                                  <a href="{{ route('staff.show', $employee->id) }}" class="text-blue-600 hover:text-blue-900 font-bold hover:underline">
    View Profile
</a>  
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>