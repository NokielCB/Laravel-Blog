<x-layout>
    <main class="max-w-md mx-auto px-4 py-10">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Rejestracja</h1>

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-100 text-red-700 p-3">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Imie</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                    class="w-full rounded-md border border-gray-300 px-3 py-2" />
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2" />
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Haslo</label>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Powtorz haslo</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                    class="w-full rounded-md border border-gray-300 px-3 py-2" />
            </div>

            <button type="submit" class="w-full rounded-md bg-indigo-600 text-white py-2 font-medium hover:bg-indigo-700">
                Utworz konto
            </button>

            <p class="text-sm text-gray-600 text-center">
                Masz juz konto?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">Zaloguj sie</a>
            </p>
        </form>
    </main>
</x-layout>
