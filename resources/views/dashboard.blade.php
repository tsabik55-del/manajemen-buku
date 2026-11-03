<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-lg font-semibold">{{ __("Selamat datang, :name!", ['name' => Auth::user()->name]) }}</p>
                    <p class="mt-2 text-sm text-gray-600">
                        Role Anda:
                        @forelse (Auth::user()->getRoleNames() as $role)
                            <span class="ms-1 inline-flex rounded-full bg-indigo-100 px-3 py-1 text-xs font-semibold text-indigo-800">
                                {{ $role }}
                            </span>
                        @empty
                            <span class="ms-1 text-gray-500">belum memiliki role</span>
                        @endforelse
                    </p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="{{ route('books.index') }}"
                   class="block bg-white p-6 shadow-sm sm:rounded-lg hover:bg-gray-50">
                    <p class="text-sm font-medium text-gray-500">Manajemen Buku</p>
                    <p class="mt-2 text-lg font-semibold text-gray-900">Lihat daftar buku &rarr;</p>
                </a>

                @can('books.create')
                    <a href="{{ route('books.create') }}"
                       class="block bg-white p-6 shadow-sm sm:rounded-lg hover:bg-gray-50">
                        <p class="text-sm font-medium text-gray-500">Tambah Buku</p>
                        <p class="mt-2 text-lg font-semibold text-gray-900">Input buku baru &rarr;</p>
                    </a>
                @endcan

                @can('users.manage-roles')
                    <a href="{{ route('users.index') }}"
                       class="block bg-white p-6 shadow-sm sm:rounded-lg hover:bg-gray-50">
                        <p class="text-sm font-medium text-gray-500">Kelola Role</p>
                        <p class="mt-2 text-lg font-semibold text-gray-900">Atur role pengguna &rarr;</p>
                    </a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
