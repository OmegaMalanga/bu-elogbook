<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Users
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-4 items-end">
                    <div>
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email"
                            class="rounded-md border border-slate-300 bg-slate-50 focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">Role</label>
                        <select name="role"
                            class="rounded-md border border-slate-300 bg-slate-50 focus:border-[#0EA5B7] focus:ring-2 focus:ring-[#0EA5B7]/40">
                            <option value="">All Roles</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @selected(request('role') === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#FF7A1C]">
                        Filter
                    </button>
                    @if (request('search') || request('role'))
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-[#0EA5B7] hover:underline mb-2">Clear</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-x-auto shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Current Role</th>
                            <th class="py-2">Change Role</th>
                            <th class="py-2">Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b">
                                <td class="py-2">{{ $user->name }}</td>
                                <td class="py-2">{{ $user->email }}</td>
                                <td class="py-2">
                                    {{ $user->roles->pluck('name')->join(', ') ?: 'No role' }}
                                </td>
                                <td class="py-2">
                                    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="rounded border-gray-300">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role }}" @selected($user->hasRole($role))>
                                                    {{ $role }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select name="department_id" class="rounded border-gray-300 text-sm">
                                                <option value="">— N/A —</option>
                                                     @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" @selected($user->department_id === $department->id)>
                                                     {{ $department->name }}
                                                </option>
                                                @endforeach
                                        </select>
                                        <button type="submit" class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
               </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
        </div>
    </div>
</x-app-layout>