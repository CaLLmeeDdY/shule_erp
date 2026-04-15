<x-app-layout>
    <x-slot name="header">
        {{ $moduleName }} Module
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-center p-10">
                <div class="text-6xl mb-4 text-blue-200">
                    <i class="fas fa-tools"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">{{ $moduleName }} is Active</h3>
                <p class="text-gray-500 mb-6">This module is wired up and ready for development.</p>
                
                <button class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">
                    + Initialize Database Tables
                </button>
            </div>
        </div>
    </div>
</x-app-layout>