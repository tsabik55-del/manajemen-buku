<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Role Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Role Saat Ini</th>
                                <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Ubah Role</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">{{ $user->email }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @forelse ($user->roles as $role)
                                            <span class="inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-800">
                                                {{ $role->name }}
                                            </span>
                                        @empty
                                            <span class="text-gray-500">Belum ada role</span>
                                        @endforelse
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <form method="POST" action="{{ route('users.role.update', $user) }}"
                                              class="flex items-center justify-end gap-2">
                                            @csrf
                                            @method('PUT')

                                            <select name="role"
                                                    class="rounded-md border-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role }}" @selected($user->hasRole($role))>
                                                        {{ $role }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                                        </form>
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
