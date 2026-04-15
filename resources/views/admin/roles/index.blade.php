<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ __('System Access Control') }}</h2>
    </x-slot>

    <div class="py-12 space-y-8 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 shadow">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 shadow">{{ session('error') }}</div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="bg-slate-900 text-white p-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold"><i class="fas fa-users-cog mr-2"></i> User Accounts & Role Assignment</h3>
                    <p class="text-slate-400 text-sm">Manage who can login and what their title is.</p>
                </div>
                
                @if($unregisteredStaff->count() > 0)
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded text-sm shadow">
                            <i class="fas fa-user-plus mr-2"></i> Create Login for Staff
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-72 bg-white text-gray-800 rounded shadow-xl border border-gray-200 z-50 p-4">
                            <form action="{{ route('admin.users.create_staff') }}" method="POST">
                                @csrf
                                <label class="block text-xs font-bold text-gray-500 mb-1">Select Staff Member</label>
                                <select name="staff_id" class="w-full border rounded p-2 text-sm mb-3">
                                    @foreach($unregisteredStaff as $staff)
                                        <option value="{{ $staff->id }}">{{ $staff->full_name }} ({{ $staff->position }})</option>
                                    @endforeach
                                </select>
                                <label class="block text-xs font-bold text-gray-500 mb-1">Set Password</label>
                                <input type="password" name="password" value="password123" class="w-full border rounded p-2 text-sm mb-3">
                                <button type="submit" class="w-full bg-slate-800 text-white py-2 rounded font-bold text-xs hover:bg-slate-700">Create Account</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <div class="p-6">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-100 text-gray-500 uppercase text-xs">
                            <th class="p-3">User Name</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Role</th>
                            <th class="p-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50">
                                <td class="p-3 font-bold text-gray-700">{{ $user->name }}</td>
                                <td class="p-3 text-gray-500">{{ $user->email }}</td>
                                <td class="p-3">
                                    @foreach($user->roles as $role)
                                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-bold">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="p-3 text-right">
                                    <form action="{{ route('admin.users.assign') }}" method="POST" class="inline-flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <select name="role" class="text-xs border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="text-xs bg-slate-800 text-white px-3 py-1.5 rounded hover:bg-slate-700 transition">Save</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="bg-slate-900 text-white p-6 border-b border-gray-200">
                <h3 class="text-lg font-bold"><i class="fas fa-shield-alt mr-2"></i> Role Permissions</h3>
                <p class="text-slate-400 text-sm">Define what each role is allowed to do.</p>
            </div>
            
            <div class="p-6 grid grid-cols-1 gap-8" x-data="{ activeRole: null }">
                <form action="{{ route('admin.roles.store') }}" method="POST" class="flex gap-4 items-end border-b pb-6">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Create New Role</label>
                        <input type="text" name="name" placeholder="e.g. Disciplinary Master" class="w-full border-gray-300 rounded shadow-sm">
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow">Add Role</button>
                </form>

                @foreach($roles as $role)
                    <div class="border rounded-lg overflow-hidden {{ $role->name === 'Super Admin' ? 'bg-slate-50 border-slate-200' : 'bg-white' }}">
                        
                        <div class="p-4 flex justify-between items-center cursor-pointer bg-gray-50 hover:bg-gray-100 transition" @click="activeRole === {{ $role->id }} ? activeRole = null : activeRole = {{ $role->id }}">
                            <div class="flex items-center gap-3">
                                <span class="font-bold text-lg text-gray-800">{{ $role->name }}</span>
                                @if($role->name === 'Super Admin')
                                    <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded font-bold uppercase">System Core</span>
                                @else
                                    <span class="text-xs text-gray-500">{{ $role->permissions->count() }} permissions</span>
                                @endif
                            </div>
                            <i class="fas" :class="activeRole === {{ $role->id }} ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </div>

                        <div x-show="activeRole === {{ $role->id }}" class="p-6 border-t bg-white" style="display: none;">
                            @if($role->name === 'Super Admin')
                                <p class="text-green-600 font-bold"><i class="fas fa-check-circle mr-2"></i> Super Admin has full access to all modules.</p>
                            @else
                                <form action="{{ route('admin.roles.permissions', $role->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                        @foreach($permissions as $category => $perms)
                                            <div>
                                                <h4 class="font-bold text-xs uppercase text-blue-600 mb-3 border-b pb-1">{{ $category }}</h4>
                                                <div class="space-y-2">
                                                    @foreach($perms as $perm)
                                                        <label class="flex items-center space-x-2 cursor-pointer">
                                                            <input type="checkbox" name="permissions[]" value="{{ $perm->name }}" 
                                                                {{ $role->hasPermissionTo($perm->name) ? 'checked' : '' }}
                                                                class="rounded text-blue-600 focus:ring-blue-500 h-4 w-4">
                                                            <span class="text-sm text-gray-600 hover:text-gray-900">{{ str_replace('_', ' ', $perm->name) }}</span>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-6 pt-4 border-t flex justify-end">
                                        <button type="submit" class="bg-slate-800 text-white font-bold py-2 px-6 rounded hover:bg-slate-700">
                                            Update {{ $role->name }} Permissions
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="bg-indigo-900 text-white p-6 border-b border-gray-200">
                <h3 class="text-lg font-bold"><i class="fas fa-paint-brush mr-2"></i> System Branding</h3>
                <p class="text-indigo-200 text-sm">Customize the school name, logo, and login screen messages.</p>
            </div>
            
            <div class="p-6">
                <form action="{{ route('admin.settings.branding') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">School Name</label>
                        <input type="text" name="school_name" value="{{ $school_settings['school_name'] ?? 'Shule ERP' }}" class="w-full border rounded p-2">
                        <p class="text-xs text-gray-500 mt-1">Appears on Sidebar and Login Page.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Upload Logo</label>
                        <input type="file" name="school_logo" class="w-full border rounded p-1">
                        @if(!empty($school_settings['school_logo']))
                            <div class="mt-2 text-xs text-green-600 font-bold flex items-center">
                                <i class="fas fa-check-circle mr-1"></i> Current Logo Active
                                <img src="{{ asset('storage/' . $school_settings['school_logo']) }}" class="h-8 ml-2 bg-gray-200 rounded">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Login Title / Slogan</label>
                        <input type="text" name="school_slogan" value="{{ $school_settings['school_slogan'] ?? 'Excellence in Management' }}" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Login Footer / Motto</label>
                        <input type="text" name="school_motto" value="{{ $school_settings['school_motto'] ?? 'Empowering Education' }}" class="w-full border rounded p-2">
                    </div>

                    <div class="md:col-span-2 text-right">
                        <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-6 rounded shadow hover:bg-indigo-700">
                            Save Branding Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
</x-app-layout>