@php
    $user = filament()->auth()->user();
@endphp

<x-filament-widgets::widget class="fi-profile-info-widget">
    <x-filament::section
        heading="Profil administratora"
        description="Podstawowe informacje o zalogowanym koncie"
    >
        <div class="space-y-3">
            <div>
                <p class="text-sm text-gray-500">Imie i nazwisko</p>
                <p class="text-sm font-medium text-gray-950 dark:text-white">{{ $user->name }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="text-sm font-medium text-gray-950 dark:text-white">{{ $user->email }}</p>
            </div>

            <div class="flex items-center gap-2">
                <p class="text-sm text-gray-500">Rola:</p>
                <x-filament::badge :color="$user->is_admin ? 'warning' : 'gray'">
                    {{ $user->is_admin ? 'Administrator' : 'Uzytkownik' }}
                </x-filament::badge>
            </div>

            <div>
                <p class="text-sm text-gray-500">Dolaczyl</p>
                <p class="text-sm font-medium text-gray-950 dark:text-white">{{ $user->created_at->format('d.m.Y') }}</p>
            </div>
        </div>

        <x-filament::button
            tag="a"
            :href="route('filament.admin.resources.users.edit', $user)"
            icon="heroicon-m-pencil-square"
            color="warning"
            class="mt-4"
        >
            Edytuj profil
        </x-filament::button>
    </x-filament::section>
</x-filament-widgets::widget>
