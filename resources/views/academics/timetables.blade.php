<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Timetable Management</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow relative" role="alert">
                    <strong class="font-bold">Conflict Detected!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow mb-8 no-print border-t-4 border-blue-600">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                        <i class="fas fa-calendar-plus text-blue-500"></i> Assign New Lesson
                    </h3>
                    <div class="text-sm text-gray-500">
                        Total Teachers: <span class="font-bold text-gray-800">{{ $teachers->count() }}</span>
                    </div>
                </div>

                <form action="{{ route('academics.timetables.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                    @csrf
                    
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Class</label>
                        <select name="stream_id" class="w-full border-gray-300 rounded focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Class...</option>
                            @foreach($streams as $stream)
                                <option value="{{ $stream->id }}">
                                    {{ $stream->schoolClass?->name ?? 'Unassigned' }} {{ $stream->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Day</label>
                        <select name="day_of_week" class="w-full border-gray-300 rounded focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Period</label>
                        <select name="period_id" class="w-full border-gray-300 rounded focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Time...</option>
                            @foreach($periods as $period)
                                <option value="{{ $period->id }}" {{ $period->is_break ? 'disabled class=bg-gray-100 text-gray-400' : '' }}>
                                    {{ $period->name }} 
                                    ({{ \Carbon\Carbon::parse($period->start_time)->format('H:i') }})
                                    {{ $period->is_break ? '(Break)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Subject</label>
                        <select name="subject_id" class="w-full border-gray-300 rounded focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Subject...</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->code }} - {{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Teacher</label>
                        <select name="teacher_id" class="w-full border-gray-300 rounded focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Select Teacher...</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-1 flex items-end">
                        <button type="submit" class="w-full bg-slate-800 text-white py-2 px-4 rounded font-bold hover:bg-slate-700 transition duration-150">
                            + Add To Schedule
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-8 rounded-lg shadow" id="printableArea">
                
                <div class="hidden print-header mb-8 text-center">
                    <h1 class="text-3xl font-bold text-gray-900">SHULE ERP SCHOOL</h1>
                    <p class="text-gray-500 text-sm">Official Master Timetable • Generated on {{ date('d M Y') }}</p>
                </div>

                <div class="flex justify-between items-center mb-6 no-print">
                    <h3 class="font-bold text-2xl text-gray-800">Master School Schedule</h3>
                    <div class="flex gap-2">
                        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded font-bold hover:bg-blue-700 shadow flex items-center gap-2">
                            <i class="fas fa-print"></i> Print All
                        </button>
                    </div>
                </div>

                @if($streams->isEmpty())
                    <div class="text-center py-12 text-gray-400 bg-gray-50 rounded border border-dashed border-gray-300">
                        <i class="fas fa-chalkboard text-4xl mb-3"></i>
                        <p>No classes found. Go to "Classes" to set up your streams first.</p>
                    </div>
                @else
                    @foreach($streams as $stream)
                        <div class="mb-12 page-break">
                            <div class="flex justify-between items-end border-b-2 border-slate-800 mb-3 pb-1">
                                <h4 class="font-bold text-xl text-slate-800">
                                    {{ $stream->schoolClass?->name ?? 'Unassigned' }} <span class="text-blue-600">{{ $stream->name }}</span>
                                </h4>
                                <span class="text-xs text-gray-500 font-bold uppercase tracking-wider">
                                    Class Teacher: {{ $stream->teacher?->name ?? 'Unassigned' }}
                                </span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse border border-gray-300 text-xs">
                                    <thead>
                                        <tr class="bg-slate-100 text-slate-700">
                                            <th class="border border-gray-300 p-2 w-24 text-left uppercase font-bold">Day / Time</th>
                                            @foreach($periods as $period)
                                                <th class="border border-gray-300 p-2 text-center w-32 {{ $period->is_break ? 'bg-gray-200' : '' }}">
                                                    <span class="block font-bold">{{ $period->name }}</span>
                                                    <span class="block text-xxs text-gray-500">{{ \Carbon\Carbon::parse($period->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($period->end_time)->format('H:i') }}</span>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                            <tr>
                                                <td class="border border-gray-300 p-2 font-bold bg-gray-50 text-gray-700">{{ $day }}</td>
                                                
                                                @foreach($periods as $period)
                                                    <td class="border border-gray-300 p-1 text-center h-16 relative group {{ $period->is_break ? 'bg-gray-100' : 'hover:bg-blue-50 transition' }}">
                                                        
                                                        @if($period->is_break)
                                                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                                                <span class="text-gray-300 text-xs font-bold tracking-widest -rotate-45 select-none">///</span>
                                                            </div>
                                                        @else
                                                            @php
                                                                // Note: Ensure TimetableEntry model is imported or use full path
                                                                $lesson = \App\Models\TimetableEntry::where('stream_id', $stream->id)
                                                                    ->where('day_of_week', $day)
                                                                    ->where('period_id', $period->id)
                                                                    ->with(['subject', 'teacher'])
                                                                    ->first();
                                                            @endphp

                                                            @if($lesson)
                                                                <div class="flex flex-col justify-center h-full cursor-pointer">
                                                                    <span class="font-bold text-blue-700 text-sm">{{ $lesson->subject?->code ?? 'SUB' }}</span>
                                                                    <span class="text-xxs text-gray-600 truncate max-w-[100px] mx-auto">{{ $lesson->teacher?->name ?? 'TBA' }}</span>
                                                                </div>
                                                            @else
                                                                <span class="text-gray-100 text-xl font-bold select-none">+</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>
    </div>

    <style>
        @media print {
            .no-print { display: none !important; }
            .print-header { display: block !important; }
            body { background: white; font-size: 10pt; -webkit-print-color-adjust: exact; }
            .page-break { page-break-after: always; margin-top: 2rem; }
            nav, header, footer { display: none; }
            .shadow { box-shadow: none !important; }
        }
    </style>
</x-app-layout>