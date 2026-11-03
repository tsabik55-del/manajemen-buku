<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Buku') }}
            </h2>

            <div class="flex items-center gap-3">
                @can('books.update')
                    <a href="{{ route('books.edit', $book) }}"
                       class="inline-flex items-center rounded-md bg-amber-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-amber-600">
                        {{ __('Edit') }}
                    </a>
                @endcan

                @can('books.delete')
                    <form method="POST" action="{{ route('books.destroy', $book) }}"
                          onsubmit="return confirm('Hapus buku ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center rounded-md bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white hover:bg-red-700">
                            {{ __('Hapus') }}
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Judul</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $book->title }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Penulis</p>
                        <p class="text-gray-900">{{ $book->author }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">ISBN</p>
                        <p class="text-gray-900">{{ $book->isbn }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Tahun Terbit</p>
                        <p class="text-gray-900">{{ $book->year ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Deskripsi</p>
                        <p class="whitespace-pre-line text-gray-900">{{ $book->description ?? '-' }}</p>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('books.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                            &larr; Kembali ke daftar buku
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
