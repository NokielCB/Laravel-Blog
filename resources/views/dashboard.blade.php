<x-layout>
    <main class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
        <p class="text-gray-600 mb-8">Witaj, {{ auth()->user()->name }}. Jestes zalogowany.</p>

        <div class="grid gap-4 sm:grid-cols-2">
            <a href="{{ route('posts.create') }}"
                class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
                <h2 class="font-semibold text-gray-900 mb-1">Dodaj nowy post</h2>
                <p class="text-sm text-gray-600">Przejdz do formularza tworzenia posta.</p>
            </a>

            <a href="{{ route('posts.index') }}"
                class="rounded-lg border border-gray-200 bg-white p-5 shadow-sm hover:shadow-md transition-shadow">
                <h2 class="font-semibold text-gray-900 mb-1">Przegladaj posty</h2>
                <p class="text-sm text-gray-600">Wroc do listy wszystkich artykulow.</p>
            </a>
        </div>
    </main>
</x-layout>
