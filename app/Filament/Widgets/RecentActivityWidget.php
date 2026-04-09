<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivityWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table
            ->query(Post::query()->with('user')->latest('created_at')->limit(5))
            ->columns([
                TextColumn::make('title')
                    ->label('Post Title')
                    ->limit(40),
                
                TextColumn::make('user.name')
                    ->label('Author')
                    ->default('Unknown'),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y H:i'),
                
                TextColumn::make('is_published')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Published' : 'Draft')
                    ->color(fn ($state) => $state ? 'success' : 'warning'),
            ])
            ->paginated(false);
    }

    public static function getHeading(): string
    {
        return 'Recent Posts';
    }
}
