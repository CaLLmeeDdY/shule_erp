<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Class & Stream Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="col-span-1 space-y-6">
                    
                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Step 1: Create Class Level</h3>
                        <form action="{{ route('academics.classes.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Class Name</label>
                                <input type="text" name="name" placeholder="e.g. Form 1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>
                            <button type="submit" class="w-full bg-slate-900 text-white py-2 rounded-md hover:bg-slate-800 transition">
                                <i class="fas fa-plus mr-2"></i> Add Level
                            </button>
                        </form>
                    </div>

                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Step 2: Add Stream & Teacher</h3>
                        <form action="{{ route('academics.streams.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Select Level</label>
                                <select name="class_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                                    <option value="">-- Select Class --</option>
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Stream Name</label>
                                <input type="text" name="stream_name" placeholder="e.g. East, Blue" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Class Teacher</label>
                                <select name="teacher_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Assign Teacher --</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                                <i class="fas fa-plus mr-2"></i> Add Stream
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2">
                    <div class="bg-white p-6 shadow-md rounded-lg">
                        <h3 class="font-bold text-gray-800 mb-4 text-lg border-b pb-2">
                            <i class="fas fa-network-wired mr-2 text-blue-600"></i> Current School Structure
                        </h3>

                        @if($classes->isEmpty())
                            <div class="text-center py-10 text-gray-400">
                                <p>No classes defined yet.</p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($classes as $class)
                                    <div class="border rounded-lg p-4 hover:shadow-md transition bg-gray-50">
                                        
                                        <div class="flex justify-between items-center border-b pb-2 mb-2">
                                            <div class="flex items-center gap-2">
                                                <h4 class="font-bold text-xl text-gray-800">{{ $class->name }}</h4>
                                                
                                                <form action="{{ route('academics.classes.destroy', $class->id) }}" method="POST" onsubmit="return confirm('Delete class?');" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="text-xs text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                            <span class="bg-slate-800 text-white text-xs font-bold px-2 py-1 rounded">
                                                {{ $class->streams->count() }} STREAMS
                                            </span>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                            @forelse($class->streams as $stream)
                                                <div class="flex justify-between items-center p-3 bg-white border border-gray-200 rounded shadow-sm">
                                                    
                                                    <div>
                                                        <div class="font-bold text-gray-800 text-lg">{{ $stream->name }}</div>
                                                        
                                                        @if($stream->pivot->teacher)
                                                            <div class="text-xs text-blue-700 font-bold mt-1">
                                                                <i class="fas fa-user-tie mr-1"></i> 
                                                                Tr. {{ $stream->pivot->teacher->name }}
                                                            </div>
                                                        @else
                                                            <div class="text-xs text-red-400 italic mt-1">No Teacher</div>
                                                        @endif
                                                    </div>

                                                    <form action="{{ route('academics.streams.remove', ['class' => $class->id, 'stream' => $stream->id]) }}" method="POST" onsubmit="return confirm('Remove stream?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                                            <i class="fas fa-times-circle text-lg"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @empty
                                                <div class="text-sm text-gray-400 italic">No streams created yet.</div>
                                            @endforelse
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