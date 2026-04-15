<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Exam Management</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded shadow col-span-1 h-fit">
                    <h3 class="font-bold text-lg mb-4 text-blue-800">Create New Exam Cycle</h3>
                    <form action="{{ route('academics.exams.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-bold text-gray-700">Exam Name</label>
                            <input type="text" name="name" placeholder="e.g. Term 1 End Exam" class="w-full border rounded p-2" required>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mb-3">
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Term</label>
                                <select name="term" class="w-full border rounded p-2">
                                    <option>Term 1</option>
                                    <option>Term 2</option>
                                    <option>Term 3</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Year</label>
                                <input type="number" name="year" value="{{ date('Y') }}" class="w-full border rounded p-2" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-2 mb-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700">Start Date</label>
                                <input type="date" name="start_date" class="w-full border rounded p-2" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700">End Date</label>
                                <input type="date" name="end_date" class="w-full border rounded p-2" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700">Create Exam Cycle</button>
                    </form>
                </div>

                <div class="bg-white p-6 rounded shadow col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-lg text-gray-800">Exam History</h3>
                        <a href="{{ route('academics.exams.marks') }}" class="bg-green-600 text-white px-4 py-2 rounded font-bold hover:bg-green-700">
                            <i class="fas fa-edit mr-2"></i> Enter Marks
                        </a>
                    </div>
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 uppercase text-xs text-gray-600">
                            <tr>
                                <th class="p-3">Exam Name</th>
                                <th class="p-3">Dates</th>
                                <th class="p-3">Status</th>
                                <th class="p-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exams as $exam)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-bold">{{ $exam->name }}</td>
                                    <td class="p-3 text-gray-600">{{ $exam->start_date }} to {{ $exam->end_date }}</td>
                                    <td class="p-3">
                                        @if($exam->is_published)
                                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-bold">Published</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-bold">Internal</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right">
                                        <button class="text-blue-600 hover:text-blue-900 text-xs font-bold uppercase">View Analytics</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
