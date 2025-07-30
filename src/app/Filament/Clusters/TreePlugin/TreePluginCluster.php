<?php

namespace App\Filament\Clusters\TreePlugin;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class TreePluginCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
    protected static string | \UnitEnum | null $navigationGroup = 'Plugins';
}
