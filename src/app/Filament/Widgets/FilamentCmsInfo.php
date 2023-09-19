<?php

namespace App\Filament\Widgets;

use Composer\InstalledVersions;
use Filament\Widgets\Widget;

class FilamentCmsInfo extends Widget
{
    protected static string $view = 'filament.widgets.filament-cms-info';

    protected int | string | array $columnSpan = 'full';

    public function getFilamentCmsPluginInstallVersion()
    {
        return InstalledVersions::getPrettyVersion($this->getPackageName());
    }

    public function getFilamentCmsPluginLink()
    {
        return 'https://filamentphp.com/plugins/solution-forest-cms-website';
    }

    public function getFilamentCmsPluginDocLink()
    {
        return route('filament-cms.web.page', [
            'slug' => 'docs',
        ]);
    }

    private function getPackageName(): string
    {
        return 'solution-forest/filament-cms-website-plugin';
    }
}
