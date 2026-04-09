<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        try {
            $totalPosts = Post::count();
            $publishedPosts = Post::where('is_published', true)->count();
            $draftPosts = $totalPosts - $publishedPosts;

            return [
                Stat::make('Total Posts', (string) $totalPosts)
                    ->description('All blog posts')
                    ->descriptionIcon('heroicon-m-document-text')
                    ->color('success'),
                
                Stat::make('Published', (string) $publishedPosts)
                    ->description('Live posts')
                    ->descriptionIcon('heroicon-m-check-circle')
                    ->color('primary'),
                
                Stat::make('Drafts', (string) $draftPosts)
                    ->description('Unpublished posts')
                    ->descriptionIcon('heroicon-m-pencil')
                    ->color('warning'),
            ];
        } catch (\Exception $e) {
            return [
                Stat::make('Error', 'Cannot load stats')
                    ->color('danger'),
            ];
        }
    }
}
