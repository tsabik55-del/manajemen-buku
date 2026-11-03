<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Buku') }}
            </h2>

            @can('books.create')
                <a href="{{ route('books.create') }}"
                   class="inline-flex items-center rounded-md bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-gray-700">
                    {{ __('Tambah Buku') }}
                </a>
            @endcan
        </div>
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
                    @if ($books->isEmpty())
                        <p class="text-gray-600">{{ __('Belum ada buku.') }}</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Judul</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Penulis</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">ISBN</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Tahun</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($books as $book)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $book->title }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $book->author }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $book->isbn }}</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $book->year ?? '-' }}</td>
                                        <td class="px-4 py-3 text-right text-sm">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="{{ route('books.show', $book) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>

                                                @can('books.update')
                                                    <a href="{{ route('books.edit', $book) }}" class="text-amber-600 hover:text-amber-800">Edit</a>
                                                @endcan

                                                @can('books.delete')
                                                    <form method="POST" action="{{ route('books.destroy', $book) }}"
                                                          onsubmit="return confirm('Hapus buku ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $books->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
