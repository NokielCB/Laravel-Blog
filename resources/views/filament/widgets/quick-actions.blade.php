<x-filament-widgets::widget class="fi-quick-actions-widget">
    <x-filament::section
        heading="Szybkie akcje"
        description="Najczesciej uzywane akcje administracyjne"
    >
        <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
            <x-filament::button
                tag="a"
                :href="route('filament.admin.resources.posts.create')"
                icon="heroicon-m-pencil-square"
                color="warning"
            >
                Dodaj post
            </x-filament::button>

            <x-filament::button
                tag="a"
                :href="route('filament.admin.resources.users.create')"
                icon="heroicon-m-user-plus"
                color="primary"
            >
                Dodaj uzytkownika
            </x-filament::button>

            <x-filament::button
                tag="a"
                :href="route('filament.admin.resources.posts.index')"
                icon="heroicon-m-document-text"
                color="success"
            >
                Wszystkie posty
            </x-filament::button>

            <x-filament::button
                tag="a"
                :href="route('posts.index')"
                icon="heroicon-m-arrow-left"
                color="gray"
            >
                Powrot na strone glowna
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
