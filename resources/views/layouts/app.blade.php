<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Shule ERP') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Custom sleek scrollbar for the sidebar */
            .sidebar-scroll::-webkit-scrollbar { width: 4px; }
            .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
            .sidebar-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
            .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: #475569; }
        </style>
    </head>
    <body class="font-sans antialiased bg-[#f4f7f6] text-gray-900" x-data="{ sidebarOpen: true }">
        
        <div class="flex h-screen overflow-hidden">
            
            <aside class="w-64 flex-shrink-0 bg-[#0B1120] text-white flex flex-col transition-all duration-300 z-20">
                
                <div class="h-16 flex items-center px-6 border-b border-gray-800/50">
                    <svg class="w-7 h-7 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72l5 2.73 5-2.73v3.72z"/>
                    </svg>
                    <span class="text-[1.1rem] font-extrabold tracking-wide uppercase">Shule ERP</span>
                </div>

                <div class="flex-1 overflow-y-auto sidebar-scroll py-4 px-3 space-y-1">
                    @include('layouts.navigation')
                </div>
            </aside>

            <div class="flex-1 flex flex-col h-screen overflow-hidden">
                
                <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-10">
                    
                    <div class="flex items-center">
                        @if (isset($header))
                            <h2 class="text-xl font-bold text-gray-800">
                                {{ $header }}
                            </h2>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 font-medium">System Administrator</div>
                        </div>
                        
                        <div class="h-10 w-10 rounded-full bg-blue-100 border border-blue-200 text-blue-700 flex items-center justify-center font-bold shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>

                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-[#f8fafc] p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

    </body>
</html>