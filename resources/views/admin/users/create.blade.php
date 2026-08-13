<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add New User
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full rounded-md border border-slate-300 bg-slate-50 focus:border-[#0EA5B7]">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full rounded-md border border-slate-300 bg-slate-50 focus:border-[#0EA5B7]">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">Role</label>
                        <select name="role" id="role-select"
                            class="w-full rounded-md border border-slate-300 bg-slate-50 focus:border-[#0EA5B7]">
                            <option value="">— Select —</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4" id="department-field"
                        style="{{ old('role') === 'university_supervisor' ? '' : 'display:none;' }}">
                        <label class="block text-sm font-semibold text-[#1E2A78] mb-1">Engineering Department</label>
                        <select name="department_id"
                            class="w-full rounded-md border border-slate-300 bg-slate-50 focus:border-[#0EA5B7]">
                            <option value="">— Select —</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                        class="px-4 py-2 rounded-md font-semibold text-white bg-gradient-to-r from-[#FF9F1C] to-[#0EA5B7]">
                        Create User & Send Login Details
                    </button>
                </form>
            </div>

        </div>
    </div>

    <script>
        document.getElementById('role-select').addEventListener('change', function () {
            document.getElementById('department-field').style.display =
                this.value === 'university_supervisor' ? '' : 'none';
        });
    </script>
</x-app-layout>