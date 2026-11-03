<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <x-input-label for="title" :value="__('Judul')" />
        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                      :value="old('title', $book?->title)" required autofocus />
        <x-input-error :messages="$errors->get('title')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="author" :value="__('Penulis')" />
        <x-text-input id="author" name="author" type="text" class="mt-1 block w-full"
                      :value="old('author', $book?->author)" required />
        <x-input-error :messages="$errors->get('author')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="isbn" :value="__('ISBN')" />
        <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full"
                      :value="old('isbn', $book?->isbn)" required />
        <x-input-error :messages="$errors->get('isbn')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="year" :value="__('Tahun Terbit')" />
        <x-text-input id="year" name="year" type="number" class="mt-1 block w-full"
                      :value="old('year', $book?->year)" min="1000" max="{{ date('Y') + 1 }}" />
        <x-input-error :messages="$errors->get('year')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="description" :value="__('Deskripsi')" />
        <textarea id="description" name="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $book?->description) }}</textarea>
        <x-input-error :messages="$errors->get('description')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('books.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Batal</a>
        <x-primary-button>{{ __('Simpan') }}</x-primary-button>
    </div>
</form>
