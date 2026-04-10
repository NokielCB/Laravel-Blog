<x-layout>
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Edytuj post</h2>
            <p class="mt-2 text-gray-600">Zmien tresc, slug, zdjecie i status publikacji.</p>
        </div>

        <section class="bg-white rounded-lg shadow-md border border-gray-100 p-6 sm:p-8">
            @if ($errors->any())
                <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
                    <p class="font-semibold">Popraw bledy w formularzu:</p>
                    <ul class="mt-2 list-disc pl-5 text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Tytul</label>
                    <input
                        id="title"
                        type="text"
                        name="title"
                        value="{{ old('title', $post->title) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Np. Jak zaczac z Laravel"
                    >
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Przyjazny adres (slug)</label>
                    <input
                        id="slug"
                        type="text"
                        name="slug"
                        value="{{ old('slug', $post->slug) }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="np-jak-zaczac-z-laravel"
                    >
                    @error('slug')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="lead" class="block text-sm font-medium text-gray-700 mb-2">Zajawka</label>
                    <textarea
                        id="lead"
                        name="lead"
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none"
                        placeholder="Krotkie podsumowanie wpisu"
                    >{{ old('lead', $post->lead) }}</textarea>
                    @error('lead')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Tresc</label>
                    <textarea
                        id="content"
                        name="content"
                        rows="10"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        placeholder="Napisz tresc posta..."
                    >{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Zdjecie posta</label>

                    @if ($post->photo)
                        <div class="mb-3">
                            <img src="{{ Storage::disk('public')->url($post->photo) }}" alt="Aktualne zdjecie posta"
                                class="h-36 rounded-lg border border-gray-200 object-cover">
                        </div>

                        <label for="remove_photo" class="mb-3 flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input
                                id="remove_photo"
                                type="checkbox"
                                name="remove_photo"
                                value="1"
                                class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                            >
                            Usun obecne zdjecie
                        </label>
                    @endif

                    <input
                        id="photo"
                        type="file"
                        name="photo"
                        accept="image/png,image/jpeg,image/webp"
                        class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                    >
                    <p class="mt-2 text-xs text-gray-500">Dozwolone: JPG, PNG, WEBP. Maksymalnie 3MB.</p>
                    @error('photo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
                    <label for="is_published" class="flex items-center gap-3 cursor-pointer">
                        <input
                            id="is_published"
                            type="checkbox"
                            name="is_published"
                            value="1"
                            @checked(old('is_published', $post->is_published))
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        >
                        <span class="text-sm text-gray-800">
                            Oznacz jako publiczny (post bedzie widoczny jako opublikowany)
                        </span>
                    </label>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <a
                        href="{{ route('dashboard') }}"
                        class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-center font-medium hover:bg-gray-50"
                    >
                        Anuluj
                    </a>
                    <button
                        type="submit"
                        class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700"
                    >
                        Zapisz zmiany
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');

            if (!titleInput || !slugInput) {
                return;
            }

            let slugTouched = slugInput.value.trim().length > 0;

            const polishMap = {
                'a': /[ą]/g,
                'c': /[ć]/g,
                'e': /[ę]/g,
                'l': /[ł]/g,
                'n': /[ń]/g,
                'o': /[ó]/g,
                's': /[ś]/g,
                'z': /[żź]/g,
            };

            const slugify = (value) => {
                let normalized = value.toLowerCase();

                Object.entries(polishMap).forEach(([replacement, pattern]) => {
                    normalized = normalized.replace(pattern, replacement);
                });

                return normalized
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
            };

            titleInput.addEventListener('input', () => {
                if (slugTouched) {
                    return;
                }

                slugInput.value = slugify(titleInput.value);
            });

            slugInput.addEventListener('input', () => {
                slugTouched = slugInput.value.trim().length > 0;
            });
        });
    </script>
</x-layout>
