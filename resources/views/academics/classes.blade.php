<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Class & Stream Management</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="space-y-6">
                    
                    <div class="bg-white p-6 rounded shadow">
                        <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Step 1: Create Class Level</h3>
                        <form action="{{ route('academics.classes.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Class Name</label>
                                <input type="text" name="name" placeholder="e.g. Form 1" class="w-full border-gray-300 rounded" required>
                            </div>
                            <button class="w-full bg-slate-800 text-white py-2 rounded font-bold hover:bg-slate-700">
                                + Add Level
                            </button>
                        </form>
                    </div>

                    <div class="bg-white p-6 rounded shadow">
                        <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Step 2: Add Stream</h3>
                        <form action="{{ route('academics.streams.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Select Level</label>
                                <select name="school_class_id" class="w-full border-gray-300 rounded" required>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Stream Name</label>
                                <input type="text" name="name" placeholder="e.g. East, Blue" class="w-full border-gray-300 rounded" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Class Teacher</label>
                                <select name="class_teacher_id" class="w-full border-gray-300 rounded">
                                    <option value="">-- Select Teacher --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->full_name }} ({{ $teacher->tsc_number }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium">Capacity</label>
                                <input type="number" name="capacity" value="45" class="w-full border-gray-300 rounded">
                            </div>
                            <button class="w-full bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700">
                                + Add Stream
                            </button>
                        </form>
                    </div>

                </div>

                <div class="md:col-span-2">
                    <div class="bg-white p-6 rounded shadow">
                        <h3 class="font-bold text-xl text-gray-800 mb-6 flex items-center gap-2">
                            <i class="fas fa-sitemap text-blue-500"></i> Current School Structure
                        </h3>

                        @if($classes->isEmpty())
                            <div class="text-center py-10 text-gray-400">
                                <i class="fas fa-school text-4xl mb-3"></i>
                                <p>No classes defined yet. Use the form on the left.</p>
                            </div>
                        @else
                            <div class="space-y-6">
                                @foreach($classes as $class)
                                    <div class="border rounded-lg overflow-hidden">
                                        <div class="bg-slate-100 px-4 py-3 border-b flex justify-between items-center">
                                            <h4 class="font-bold text-lg text-slate-800">{{ $class->name }}</h4>
                                            <span class="text-xs font-bold text-slate-500 uppercase">{{ $class->streams->count() }} Streams</span>
                                        </div>
                                        
                                        <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            @foreach($class->streams as $stream)
                                                <div class="bg-white border border-blue-100 rounded p-3 shadow-sm hover:shadow-md transition">
                                                    <div class="flex justify-between items-start mb-2">
                                                        <span class="font-bold text-blue-600 text-lg">{{ $stream->name }}</span>
                                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">Cap: {{ $stream->capacity }}</span>
                                                    </div>
                                                    <div class="text-sm text-gray-600">
                                                        <i class="fas fa-chalkboard-teacher mr-1 text-gray-400"></i>
                                                        {{ $stream->class_teacher->full_name ?? 'No Teacher Assigned' }}
                                                    </div>
                                                </div>
                                            @endforeach
                                            @if($class->streams->isEmpty())
                                                <div class="text-sm text-gray-400 italic">No streams added to {{ $class->name }} yet.</div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>