<?php

namespace App\Filament\Tabs\Components;

use Filament\Widgets\FilamentInfoWidget as ComponentTabComponent;
use SolutionForest\TabLayoutPlugin\Components\Tabs\TabLayoutComponent;

class FilamentInfoWidget extends TabLayoutComponent
{
    protected ?string $component = ComponentTabComponent::class;

    public function getData(): array
    {
        return [
            // Data to assign to component
        ];
    }
}
