<x-layout>
    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900">Profil</h2>
                <p class="mt-2 text-gray-600">Zmien dane konta i opcjonalnie zaktualizuj haslo.</p>
            </div>

            <div class="flex gap-3">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-gray-900 text-white font-medium hover:bg-gray-800">
                        Wyloguj
                    </button>
                </form>
            </div>
        </div>

        @if (session('profile_saved'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
                {{ session('profile_saved') }}
            </div>
        @endif

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

        <section class="bg-white rounded-lg shadow-md border border-gray-100 p-6 sm:p-8">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
                @csrf
                @method('PATCH')

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Imie</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name', $user->name) }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email', $user->email) }}"
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-gray-50 p-5 space-y-5">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Zmiana hasla</h3>
                        <p class="mt-1 text-sm text-gray-600">Wpisz obecne haslo tylko wtedy, gdy chcesz ustawic nowe.</p>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Obecne haslo</label>
                            <input
                                id="current_password"
                                name="current_password"
                                type="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                autocomplete="current-password"
                            >
                            @error('current_password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Nowe haslo</label>
                            <input
                                id="password"
                                name="password"
                                type="password"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                                autocomplete="new-password"
                            >
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Powtorz nowe haslo</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                            autocomplete="new-password"
                        >
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <a href="{{ route('dashboard') }}"
                        class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 text-center font-medium hover:bg-gray-50">
                        Anuluj
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-indigo-600 text-white font-medium hover:bg-indigo-700">
                        Zapisz profil
                    </button>
                </div>
            </form>
        </section>
    </main>
</x-layout>