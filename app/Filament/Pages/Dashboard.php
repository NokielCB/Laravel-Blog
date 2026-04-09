<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PostStatsWidget;
use App\Filament\Widgets\ProfileInfoWidget;
use App\Filament\Widgets\QuickActionsWidget;
use App\Filament\Widgets\RecentActivityWidget;
use App\Filament\Widgets\RecentUsersWidget;
use App\Filament\Widgets\UserStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            ProfileInfoWidget::class,
            UserStatsWidget::class,
            PostStatsWidget::class,
            QuickActionsWidget::class,
            RecentActivityWidget::class,
            RecentUsersWidget::class,
        ];
    }
}
