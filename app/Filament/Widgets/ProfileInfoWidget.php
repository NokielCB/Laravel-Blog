<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ProfileInfoWidget extends Widget
{
    protected string $view = 'filament.widgets.profile-info';

    protected int | string | array $columnSpan = 'full';
}
