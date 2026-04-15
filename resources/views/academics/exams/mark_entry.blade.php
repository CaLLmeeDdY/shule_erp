<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Enter Marks</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-6 rounded shadow mb-6">
                <form method="GET" action="{{ route('academics.exams.marks') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="font-bold text-xs uppercase text-gray-500">1. Select Exam</label>
                        <select name="exam_id" class="w-full border rounded p-2" required>
                            <option value="">-- Choose Exam --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ request('exam_id') == $exam->id ? 'selected' : '' }}>{{ $exam->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-xs uppercase text-gray-500">2. Select Class Stream</label>
                        <select name="stream_id" class="w-full border rounded p-2" required>
                            <option value="">-- Choose Class --</option>
                            @foreach($classes as $class)
                                <optgroup label="{{ $class->name }}">
                                    @foreach($class->streams as $stream)
                                        <option value="{{ $stream->id }}" {{ request('stream_id') == $stream->id ? 'selected' : '' }}>{{ $class->name }} {{ $stream->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="font-bold text-xs uppercase text-gray-500">3. Select Subject</label>
                        <select name="subject_id" class="w-full border rounded p-2" required>
                            <option value="">-- Choose Subject --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->code }} - {{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded font-bold hover:bg-blue-700">Load Students</button>
                </form>
            </div>

            @if(isset($students) && count($students) > 0)
                <div class="bg-white p-6 rounded shadow">
                    <div class="flex justify-between mb-4 border-b pb-2">
                        <div>
                            <h3 class="font-bold text-xl text-gray-800">Mark Sheet</h3>
                            <p class="text-sm text-gray-500">
                                Exam: <span class="font-bold text-black">{{ $selectedExam->name }}</span> | 
                                Class: <span class="font-bold text-black">{{ $selectedStream->name }}</span> | 
                                Subject: <span class="font-bold text-black">{{ $selectedSubject->name }}</span>
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2 py-1 rounded">Autosave: OFF (Click Save)</span>
                        </div>
                    </div>

                    <form action="{{ route('academics.exams.marks.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="exam_id" value="{{ $selectedExam->id }}">
                        <input type="hidden" name="subject_id" value="{{ $selectedSubject->id }}">

                        <table class="w-full text-sm">
                            <thead class="bg-gray-100 uppercase text-xs font-bold">
                                <tr>
                                    <th class="p-3 text-left w-10">#</th>
                                    <th class="p-3 text-left">Adm No</th>
                                    <th class="p-3 text-left">Student Name</th>
                                    <th class="p-3 text-center w-32">Marks (Out of 100)</th>
                                    <th class="p-3 text-center w-32">Current Grade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $index => $student)
                                    @php
                                        // Check if mark exists
                                        $existingRecord = \App\Models\ExamRecord::where('exam_id', $selectedExam->id)
                                            ->where('student_id', $student->id)
                                            ->where('subject_id', $selectedSubject->id)
                                            ->first();
                                    @endphp
                                    <tr class="border-b hover:bg-blue-50">
                                        <td class="p-3">{{ $index + 1 }}</td>
                                        <td class="p-3 font-mono text-gray-500">{{ $student->adm_number }}</td>
                                        <td class="p-3 font-bold">{{ $student->full_name }}</td>
                                        <td class="p-3 text-center">
                                            <input type="number" 
                                                   name="marks[{{ $student->id }}]" 
                                                   value="{{ $existingRecord ? $existingRecord->marks_obtained : '' }}"
                                                   min="0" max="100" 
                                                   class="w-24 text-center font-bold border rounded p-1 focus:ring-2 focus:ring-blue-500"
                                                   tabindex="{{ $index + 1 }}"> </td>
                                        <td class="p-3 text-center">
                                            @if($existingRecord)
                                                <span class="font-bold {{ $existingRecord->grade == 'A' ? 'text-green-600' : ($existingRecord->grade == 'E' ? 'text-red-600' : 'text-gray-800') }}">
                                                    {{ $existingRecord->grade }}
                                                </span>
                                            @else
                                                <span class="text-gray-300">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded shadow font-bold hover:bg-green-700 text-lg">
                                <i class="fas fa-save mr-2"></i> Save Marks
                            </button>
                        </div>
                    </form>
                </div>
            @elseif(request()->has('exam_id'))
                <div class="bg-yellow-50 text-yellow-800 p-6 rounded border border-yellow-200 text-center">
                    No students found in this class.
                </div>
            @endif

        </div>
    </div>
</x-app-layout>