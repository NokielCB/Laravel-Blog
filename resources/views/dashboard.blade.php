<x-layout>
    <main class="max-w-6xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            {{ $isAdmin ?? false ? 'Dashboard administratora' : 'Moj Dashboard' }}
        </h1>
        <p class="text-gray-600 mb-8">
            @if ($isAdmin ?? false)
                Witaj, {{ auth()->user()->name }}. Mozesz edytowac wszystkie posty.
            @else
                Witaj, {{ auth()->user()->name }}. Zarzadzaj swoimi postami.
            @endif
        </p>

        @if (session('post_saved'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
                {{ session('post_saved') }}
            </div>
        @endif

        @if (session('post_deleted'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
                {{ session('post_deleted') }}
            </div>
        @endif

        <div class="mb-6 flex flex-wrap gap-3">
            <a href="{{ route('posts.create') }}"
                class="px-4 py-2 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700">
                + Dodaj nowy post
            </a>
            <a href="{{ route('posts.index') }}"
                class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50">
                Przegladaj wszystkie posty
            </a>
        </div>

        <section class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Tytul</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Data</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-700">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($posts as $post)
                            <tr class="border-b border-gray-100">
                                <td class="px-4 py-4">
                                    <a href="{{ route('posts.show', $post->slug) }}"
                                        class="font-medium text-indigo-700 hover:text-indigo-900">
                                        {{ $post->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-4">
                                    @if ($post->is_published)
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            Opublikowany
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                            Szkic
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-600">
                                    {{ $post->created_at->format('d.m.Y H:i') }}
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-end gap-2">
                                        @can('update', $post)
                                            <a href="{{ route('posts.edit', $post) }}"
                                                class="px-3 py-1.5 rounded-md bg-amber-100 text-amber-800 text-sm font-medium hover:bg-amber-200">
                                                Edytuj
                                            </a>
                                        @endcan

                                        @can('delete', $post)
                                            <form method="POST" action="{{ route('posts.destroy', $post) }}"
                                                onsubmit="return confirm('Czy na pewno chcesz usunac ten post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 rounded-md bg-red-100 text-red-800 text-sm font-medium hover:bg-red-200">
                                                    Usun
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-10 text-center text-gray-600">
                                    Nie masz jeszcze postow. Utworz pierwszy wpis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </main>
</x-layout>
