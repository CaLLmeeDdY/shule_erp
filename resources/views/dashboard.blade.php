<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('System Overview') }}
            </h2>
            <span class="text-sm text-gray-500">
                {{ now()->format('l, d M Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Active Students</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalStudents ?? 0 }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Staff</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalStaff ?? 0 }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Classes</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $totalClasses ?? 0 }}</div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Pending Alerts</div>
                    <div class="mt-2 text-3xl font-bold text-gray-900">{{ $pendingAlerts ?? 0 }}</div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="col-span-2 bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Recent Admissions</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3">Adm No</th>
                                    <th class="px-4 py-3">Student Name</th>
                                    <th class="px-4 py-3">Class</th>
                                    <th class="px-4 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($recentStudents as $student)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium text-blue-600">{{ $student->adm_number }}</td>
                                    <td class="px-4 py-3 font-bold text-gray-700">{{ $student->full_name }}</td>
                                    <td class="px-4 py-3 text-gray-500">{{ $student->class_applied }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="#" class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded hover:bg-gray-200">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500 italic">
                                        No recent students found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 text-center">
                        <a href="{{ route('students.index') }}" class="text-sm text-blue-600 font-bold hover:underline">View All Students →</a>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-gray-800">Finance Overview</h3>
                            <span class="p-2 bg-green-100 text-green-600 rounded-full">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Expected (Term 1)</span>
                                <span class="font-bold text-gray-900">KES 0.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Collected</span>
                                <span class="font-bold text-green-600">KES 0.00</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Arrears</span>
                                <span class="font-bold text-red-500">KES 0.00</span>
                            </div>
                        </div>
                        <button class="w-full mt-6 bg-gray-800 text-white py-2 rounded-md text-sm font-bold hover:bg-gray-700 transition">
                            Record New Payment
                        </button>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="font-bold text-gray-800 mb-4">System Health</h3>
                        <ul class="space-y-2 text-sm">
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500">Database</span>
                                <span class="px-2 py-0.5 rounded text-xs bg-green-100 text-green-700 font-bold">Online</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500">Backup</span>
                                <span class="px-2 py-0.5 rounded text-xs bg-yellow-100 text-yellow-700 font-bold">Pending</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-gray-500">SMS Gateway</span>
                                <span class="px-2 py-0.5 rounded text-xs bg-red-100 text-red-700 font-bold">Offline</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>