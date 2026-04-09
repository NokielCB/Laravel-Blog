<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        try {
            $totalUsers = User::count();
            $admins = User::where('is_admin', true)->count();
            $regularUsers = $totalUsers - $admins;
            
            return [
                Stat::make('Total Users', (string) $totalUsers)
                    ->description('All registered users')
                    ->descriptionIcon('heroicon-m-user-group')
                    ->color('success'),
                
                Stat::make('Administrators', (string) $admins)
                    ->description('Users with admin access')
                    ->descriptionIcon('heroicon-m-shield-check')
                    ->color('warning'),
                
                Stat::make('Regular Users', (string) $regularUsers)
                    ->description('Non-admin users')
                    ->descriptionIcon('heroicon-m-user')
                    ->color('info'),
            ];
        } catch (\Exception $e) {
            return [
                Stat::make('Error', 'Cannot load stats')
                    ->color('danger'),
            ];
        }
    }
}
