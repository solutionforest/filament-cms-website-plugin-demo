<?php

namespace App\Filament\Clusters\SimpleLightBoxPlugin;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class SimpleLightBoxPluginCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
    protected static string | \UnitEnum | null $navigationGroup = 'Plugins';
    protected static ?int $navigationSort = 12;
}
