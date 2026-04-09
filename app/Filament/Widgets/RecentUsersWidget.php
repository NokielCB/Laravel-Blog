<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentUsersWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(User::query()->latest('created_at')->limit(5))
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->limit(30),
                
                TextColumn::make('email')
                    ->label('Email')
                    ->limit(40),
                
                IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),
                
                TextColumn::make('created_at')
                    ->label('Joined')
                    ->dateTime('M d, Y'),
            ])
            ->paginated(false);
    }

    public static function getHeading(): string
    {
        return 'Recent Users';
    }
}
