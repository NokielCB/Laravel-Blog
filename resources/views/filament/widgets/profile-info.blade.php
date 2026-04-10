<x-filament-widgets::widget class="fi-profile-info-widget">
    <x-filament::section
        heading="Profil administratora"
        description="Szybki dostep do edycji zalogowanego konta"
    >
        <div class="flex flex-col gap-4 rounded-2xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-800 dark:bg-gray-950/40 sm:flex-row sm:items-center sm:justify-between">
            <div class="space-y-1">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-400">
                    Podstawowe informacje o zalogowanym koncie
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    Edytuj swoje dane konta bezposrednio z panelu admina.
                </p>
            </div>

            <x-filament::button
                tag="a"
                :href="route('filament.admin.resources.users.edit', filament()->auth()->user())"
                icon="heroicon-m-pencil-square"
                color="warning"
            >
                Edytuj profil
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
