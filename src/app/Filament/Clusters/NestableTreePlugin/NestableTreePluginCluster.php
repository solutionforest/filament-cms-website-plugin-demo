<?php

namespace App\Filament\Clusters\NestableTreePlugin;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class NestableTreePluginCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;
    protected static string | \UnitEnum | null $navigationGroup = 'Plugins';
    protected static ?int $navigationSort = 11;
    protected static ?string $navigationLabel = 'Nestable Tree';
}
