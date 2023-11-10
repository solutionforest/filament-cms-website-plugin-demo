<?php

namespace App\Filament\Widgets;

use Composer\InstalledVersions;
use Filament\Widgets\Widget;

class FilamentCmsInfo extends Widget
{
    protected static string $view = 'filament.widgets.filament-cms-info';

    protected int | string | array $columnSpan = 'full';

    public function getPluginInfos(): array
    {
        return [
            [
                'name' => 'Filament CMS Website Plugin',
                'version' => $this->getPluginInstallVersion($this->getFilamentCmsPackageName()),
                'url' => $this->getFilamentCmsPluginLink(),
            ],
            [
                'name' => 'Tree',
                'version' => $this->getPluginInstallVersion($this->getFilamentTreePackageName()),
                'url' => $this->getFilamentTreePluginLink(),
            ],
        ];
    }

    public function getFilamentCmsPluginDocLink()
    {
        return route('filament-cms.web.page', [
            'slug' => 'docs',
        ]);
    }

    public function getDemoGithubLink()
    {
        return "https://github.com/solutionforest/filament-cms-website-plugin-demo";
    }

    public function getPluginInstallVersion($packageName)
    {
        return InstalledVersions::getPrettyVersion($packageName);
    }

    private function getFilamentCmsPluginLink()
    {
        return 'https://filamentphp.com/plugins/solution-forest-cms-website';
    }

    private function getFilamentTreePluginLink()
    {
        return 'https://filamentphp.com/plugins/solution-forest-tree';
    }

    private function getFilamentCmsPackageName(): string
    {
        return 'solution-forest/filament-cms-website-plugin';
    }

    private function getFilamentTreePackageName(): string
    {
        return 'solution-forest/filament-tree';
    }
}
