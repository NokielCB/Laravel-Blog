<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class AiLaravelPostsSeeder extends Seeder
{
    public function run(): void
    {
        $authors = User::query()
            ->orderBy('id')
            ->take(2)
            ->get();

        if ($authors->count() < 2) {
            throw new \RuntimeException('Seeder wymaga co najmniej 2 kont uzytkownikow.');
        }

        $adminApprover = User::query()->where('is_admin', true)->first() ?? $authors->first();

        // Remove existing demo content before creating a fresh set.
        Post::query()->delete();

        $posts = [
            [
                'title' => 'AI Agents w Laravel: od pomyslu do MVP',
                'slug' => 'ai-agents-w-laravel-od-pomyslu-do-mvp',
                'lead' => 'Jak zbudowac prostego agenta AI w aplikacji Laravel i szybko dowiezc pierwsza wersje.',
                'content' => 'W tym wpisie pokazuje przeplyw od prototypu promptow do wdrozenia endpointu w Laravel. Skupiamy sie na walidacji danych, kolejkach i monitoringu kosztow modelu, aby rozwiazanie bylo stabilne i przewidywalne.',
            ],
            [
                'title' => 'Laravel + RAG: praktyczne wyszukiwanie wiedzy dla zespolu',
                'slug' => 'laravel-plus-rag-praktyczne-wyszukiwanie-wiedzy-dla-zespolu',
                'lead' => 'RAG w praktyce: indeksowanie dokumentacji i odpowiedzi kontekstowe bez halucynacji.',
                'content' => 'Opisuje jak podpiac warstwe RAG do aplikacji Laravel, przechowywac embeddingi i budowac odpowiedzi z cytatami. Dzieki temu zespol szybciej znajduje informacje, a odpowiedzi bota sa bardziej wiarygodne.',
            ],
            [
                'title' => 'Automatyzacja moderacji komentarzy z AI i Laravel',
                'slug' => 'automatyzacja-moderacji-komentarzy-z-ai-i-laravel',
                'lead' => 'Czy AI moze wspierac moderacje bez blokowania sensownych dyskusji?',
                'content' => 'Przedstawiam pipeline moderacyjny oparty o Laravel jobs i progi pewnosci modelu. System oznacza ryzykowne komentarze do recenzji, a bezpieczne publikuje automatycznie, co poprawia jakosc dyskusji i odciaza administratora.',
            ],
        ];

        $commentPool = [
            'Bardzo przydatny wpis, szczegolnie fragment o kolejkach i retry.',
            'Fajnie opisane. Przydalby sie jeszcze przyklad z testami integracyjnymi.',
            'Czy planujesz kontynuacje o monitoringu kosztow modelu w produkcji?',
            'Podoba mi sie praktyczne podejscie do tematu RAG w Laravel.',
            'Dzieki za konkretne wskazowki. Wdroze to u siebie w projekcie.',
            'Swietny balans miedzy teoria a kodem. Czekam na kolejny artykul.',
            'Mega pomocne. U mnie podobny flow juz dziala, ale skorzystam z Twoich usprawnien.',
            'Dobra robota. Sekcja o moderacji komentarzy to strzal w dziesiatke.',
        ];

        foreach ($posts as $index => $data) {
            $author = $authors[$index % $authors->count()];

            $post = Post::query()->create([
                'title' => $data['title'],
                'slug' => $data['slug'],
                'lead' => $data['lead'],
                'content' => $data['content'],
                'user_id' => $author->id,
                'photo' => null,
                'is_published' => true,
            ]);

            $selectedComments = collect($commentPool)
                ->shuffle()
                ->take(2)
                ->values();

            foreach ($selectedComments as $commentContent) {
                $commentAuthor = $authors->random();

                Comment::query()->create([
                    'post_id' => $post->id,
                    'parent_id' => null,
                    'user_id' => $commentAuthor->id,
                    'author' => $commentAuthor->name,
                    'email' => $commentAuthor->email,
                    'content' => $commentContent,
                    'status' => 'approved',
                    'likes_count' => 0,
                    'approved_by' => $adminApprover?->id,
                    'approved_at' => now(),
                    'rejection_reason' => null,
                    'ip_address' => null,
                    'user_agent' => null,
                ]);
            }
        }
    }
}
