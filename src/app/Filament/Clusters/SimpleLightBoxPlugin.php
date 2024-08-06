<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class SimpleLightBoxPlugin extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Plugins';
    protected static ?int $navigationSort = 10;
}
